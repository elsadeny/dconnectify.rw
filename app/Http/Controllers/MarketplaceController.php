<?php

namespace App\Http\Controllers;

use App\Enums\ListingType;
use App\Models\Listing;
use App\Support\MarketplaceOptions;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketplaceController extends Controller
{
    public function index(Request $request): View
    {
        $selectedCountry = $request->string('country')->value();
        $countryOptions = MarketplaceOptions::countryOptions();
        $selectedCountry = array_key_exists($selectedCountry, $countryOptions) ? $selectedCountry : null;
        $cityOptions = $selectedCountry ?MarketplaceOptions::cityOptions($selectedCountry) : [];
        $selectedCity = $request->string('city')->value();

        $filters = [
            'type' => $request->string('type')->value(),
            'transaction_type' => in_array($request->string('transaction_type')->value(), ['sale', 'rent', 'hire'], true)
            ? $request->string('transaction_type')->value()
            : null,
            'country' => $selectedCountry,
            'city' => array_key_exists($selectedCity, $cityOptions) ? $selectedCity : null,
        ];

        $listings = Listing::query()
            ->with('seller')
            ->published()
            ->when($filters['type'], fn($query, $type) => $query->where('type', $type))
            ->when($filters['transaction_type'], fn($query, $transactionType) => $query->where('transaction_type', $transactionType))
            ->when($filters['country'], fn($query, $country) => $query->where('country', $country))
            ->when($filters['city'], fn($query, $city) => $query->where('city', $city))
            ->latest('is_featured')
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $featured = Listing::query()
            ->with('seller')
            ->published()
            ->where('is_featured', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('home', [
            'filters' => $filters,
            'listings' => $listings,
            'featured' => $featured,
            'countries' => collect($countryOptions),
            'cities' => collect($cityOptions),
            'countryCityMap' => MarketplaceOptions::cityOptions(),
            'types' => ListingType::cases(),
            'stats' => [
                'liveListings' => Listing::query()->published()->count(),
                'verifiedSellers' => Listing::query()->published()->where('is_verified', true)->distinct('user_id')->count('user_id'),
                'countries' => count($countryOptions),
            ],
        ]);
    }

    public function show(Listing $listing): View
    {
        abort_unless($listing->status->value === 'published', 404);

        return view('listings.show', [
            'listing' => $listing->load('seller'),
            'similarListings' => Listing::query()
            ->published()
            ->where('id', '!=', $listing->id)
            ->where('type', $listing->type)
            ->latest('published_at')
            ->take(3)
            ->get(),
        ]);
    }

    public function category(Request $request, string $type)
    {
        $listingType = ListingType::tryFrom($type);

        if (!$listingType) {
            abort(404);
        }

        $filters = $request->only(['city', 'country', 'q', 'min_price', 'max_price', 'transaction_type']);
        $filters['type'] = $type;

        $query = Listing::query()->with('seller')->where('type', $type)->latest();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                    ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }

        $listings = $query->paginate(12);

        return view('listings.category', [
            'type' => $listingType,
            'listings' => $listings,
            'filters' => $filters,
            'countries' => Listing::distinct()->pluck('country'),
            'cities' => Listing::when($request->country, fn($q) => $q->where('country', $request->country))
            ->distinct()->pluck('city'),
            'countryCityMap' => Listing::select('country', 'city')
            ->distinct()
            ->get()
            ->groupBy('country')
            ->map(fn($group) => $group->pluck('city')->unique()->values()),
        ]);
    }
}