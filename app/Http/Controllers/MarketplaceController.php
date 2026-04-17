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
        $cityOptions = $selectedCountry ? MarketplaceOptions::cityOptions($selectedCountry) : [];
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
            ->when($filters['type'], fn ($query, $type) => $query->where('type', $type))
            ->when($filters['transaction_type'], fn ($query, $transactionType) => $query->where('transaction_type', $transactionType))
            ->when($filters['country'], fn ($query, $country) => $query->where('country', $country))
            ->when($filters['city'], fn ($query, $city) => $query->where('city', $city))
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
}