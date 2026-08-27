<?php

namespace Tests\Feature;

use App\Enums\ListingStatus;
use App\Enums\ListingType;
use App\Enums\UserRole;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ListingShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_listing_page_renders_when_highlights_are_a_comma_separated_string(): void
    {
        $seller = User::factory()->create([
            'role' => UserRole::Seller,
        ]);

        $listing = Listing::factory()->create([
            'user_id' => $seller->id,
            'title' => 'Test Toyota Land Cruiser Prado 2023',
            'type' => ListingType::Vehicle,
            'status' => ListingStatus::Published,
            'published_at' => now(),
            'cover_image' => 'https://example.com/cover.jpg',
            'gallery' => ['https://example.com/cover.jpg', 'https://example.com/side.jpg'],
            'details' => ['fuel' => 'Diesel'],
            'highlights' => ['Sunroof'],
        ]);

        DB::table('listings')->where('id', $listing->id)->update([
            'highlights' => 'Sunroof,7 seats,Reverse camera',
        ]);

        $this->get(route('listings.show', $listing))
            ->assertOk()
            ->assertSee('Sunroof')
            ->assertSee('7 seats')
            ->assertSee('Reverse camera');
    }
}
