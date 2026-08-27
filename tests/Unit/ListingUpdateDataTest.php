<?php

namespace Tests\Unit;

use App\Enums\ListingStatus;
use App\Enums\ListingType;
use App\Enums\UserRole;
use App\Models\Listing;
use App\Models\User;
use App\Support\ListingUpdateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListingUpdateDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_keeps_images_and_details_when_an_unrelated_field_is_updated(): void
    {
        $listing = $this->listing();
        $gallery = $listing->gallery;
        $cover = $listing->cover_image;
        $details = $listing->details;
        $highlights = $listing->highlights;

        $changed = ListingUpdateData::onlyChanged([
            'title' => 'Updated Toyota title',
            'cover_image' => null,
            'gallery' => [],
            'details' => [],
            'highlights' => [],
            'city' => null,
            'country' => 'Rwanda',
            'description' => $listing->description,
        ], $listing);

        $this->assertSame(['title' => 'Updated Toyota title'], $changed);

        $listing->update($changed);
        $listing->refresh();

        $this->assertSame('Updated Toyota title', $listing->title);
        $this->assertSame($cover, $listing->cover_image);
        $this->assertSame($gallery, $listing->gallery);
        $this->assertSame($details, $listing->details);
        $this->assertSame($highlights, $listing->highlights);
        $this->assertSame('Kigali', $listing->city);
    }

    public function test_it_updates_gallery_when_new_images_are_submitted(): void
    {
        $listing = $this->listing();
        $newGallery = [
            'https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=1400&q=80',
            'https://images.unsplash.com/photo-1549924231-f129b911e442?auto=format&fit=crop&w=1400&q=80',
        ];

        $changed = ListingUpdateData::onlyChanged([
            'gallery' => $newGallery,
            'title' => $listing->title,
        ], $listing);

        $this->assertSame(['gallery' => $newGallery], $changed);

        $listing->update($changed);
        $listing->refresh();

        $this->assertSame($newGallery, $listing->gallery);
    }

    protected function listing(): Listing
    {
        $seller = User::factory()->create([
            'role' => UserRole::Seller,
        ]);

        return Listing::factory()->create([
            'user_id' => $seller->id,
            'title' => 'Test Toyota Land Cruiser Prado 2022',
            'type' => ListingType::Vehicle,
            'status' => ListingStatus::Published,
            'country' => 'Rwanda',
            'city' => 'Kigali',
            'cover_image' => 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=1400&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=1400&q=80',
                'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1400&q=80',
                'https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=1400&q=80',
            ],
            'details' => [
                'condition' => 'Foreign used',
                'fuel' => 'Diesel',
            ],
            'highlights' => ['Sunroof', '7 seats'],
        ]);
    }
}
