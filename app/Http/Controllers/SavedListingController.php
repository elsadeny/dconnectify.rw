<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SavedListingController extends Controller
{
    public function index(): View
    {
        $listings = auth()->user()->savedListings()
            ->with('seller')
            ->latest('listing_user.created_at')
            ->paginate(12);

        return view('listings.saved', [
            'listings' => $listings,
        ]);
    }

    public function store(Listing $listing): RedirectResponse
    {
        auth()->user()->savedListings()->syncWithoutDetaching([$listing->id]);
        return back()->with('status', 'listing-saved');
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        auth()->user()->savedListings()->detach($listing->id);
        return back()->with('status', 'listing-unsaved');
    }
}