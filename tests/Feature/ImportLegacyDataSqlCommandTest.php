<?php

namespace Tests\Feature;

use App\Enums\ListingStatus;
use App\Enums\ListingType;
use App\Enums\UserRole;
use App\Models\Booking;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ImportLegacyDataSqlCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_imports_legacy_users_listings_bookings_and_saved_listings(): void
    {
        $fixture = base_path('tests/Fixtures/legacy-data-sample.sql');

        $this->artisan('legacy:import-data-sql', [
            'path' => $fixture,
            '--fresh' => true,
        ])->assertSuccessful();

        $owner = User::query()->where('legacy_id', 'owner-1')->firstOrFail();
        $buyer = User::query()->where('legacy_id', 'buyer-1')->firstOrFail();
        $listing = Listing::query()->where('legacy_id', 'car-1')->firstOrFail();
        $booking = Booking::query()->where('legacy_id', 'booking-1')->firstOrFail();

        $this->assertSame(UserRole::Seller, $owner->role);
        $this->assertSame(UserRole::Buyer, $buyer->role);
        $this->assertSame(ListingType::Vehicle, $listing->type);
        $this->assertSame(ListingStatus::Published, $listing->status);
        $this->assertSame('available', $listing->availability);
        $this->assertTrue($listing->is_featured);
        $this->assertSame('Rwanda', $listing->country);
        $this->assertSame('Kigali', $listing->city);
        $this->assertSame('Kabeza', $listing->area);
        $this->assertSame(['https://example.com/car-1-main.jpg', 'https://example.com/car-1-side.jpg'], $listing->gallery);
        $this->assertSame('Buyer One', $booking->client_name);
        $this->assertDatabaseHas('listing_user', [
            'user_id' => $buyer->id,
            'listing_id' => $listing->id,
        ]);
        $this->assertSame(1, DB::table('listing_user')->count());
    }
}
