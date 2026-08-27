<?php

namespace Tests\Unit;

use App\Casts\JsonList;
use App\Casts\JsonMap;
use App\Enums\ListingStatus;
use App\Enums\ListingType;
use App\Enums\UserRole;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class JsonListTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_reads_comma_separated_highlights_as_an_array(): void
    {
        $listing = $this->listing(['highlights' => ['Sunroof']]);

        DB::table('listings')->where('id', $listing->id)->update([
            'highlights' => 'Sunroof,7 seats,Reverse camera',
        ]);

        $listing->refresh();

        $this->assertSame(['Sunroof', '7 seats', 'Reverse camera'], $listing->highlights);
    }

    public function test_it_stores_comma_separated_highlights_as_json(): void
    {
        $listing = $this->listing();
        $listing->highlights = 'Sunroof,7 seats';
        $listing->save();

        $raw = DB::table('listings')->where('id', $listing->id)->value('highlights');

        $this->assertSame(['Sunroof', '7 seats'], json_decode($raw, true));
        $this->assertSame(['Sunroof', '7 seats'], $listing->fresh()->highlights);
    }

    public function test_it_decodes_json_maps_and_rejects_plain_strings(): void
    {
        $this->assertSame(['fuel' => 'Diesel'], JsonMap::decode('{"fuel":"Diesel"}'));
        $this->assertSame([], JsonMap::decode('Sunroof,7 seats'));
        $this->assertSame(['a', 'b'], JsonList::decode('a, b'));
    }

    /**
     * @param  array<string, mixed>  $overrides
     */
    protected function listing(array $overrides = []): Listing
    {
        $seller = User::factory()->create([
            'role' => UserRole::Seller,
        ]);

        return Listing::factory()->create(array_merge([
            'user_id' => $seller->id,
            'type' => ListingType::Vehicle,
            'status' => ListingStatus::Published,
            'published_at' => now(),
        ], $overrides));
    }
}
