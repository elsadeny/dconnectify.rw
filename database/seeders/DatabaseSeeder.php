<?php

namespace Database\Seeders;

use App\Enums\ListingStatus;
use App\Enums\ListingType;
use App\Enums\UserRole;
use App\Models\Listing;
use App\Models\User;
use App\Support\MarketplaceOptions;
use Illuminate\Support\Collection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Listing::query()->delete();

        $seller = User::query()->updateOrCreate([
            'email' => 'seller@connectify.rw',
        ], [
            'name' => 'Aline Mukamana',
            'role' => UserRole::Seller,
            'company_name' => 'Amahoro Mobility',
            'country' => 'Rwanda',
            'city' => 'Kigali',
            'phone' => '+250788123456',
            'whatsapp_number' => '+250788123456',
            'bio' => 'Trusted East African marketplace seller for mobility, property and recruitment.',
            'password' => Hash::make('password'),
        ]);

        User::query()->updateOrCreate([
            'email' => 'admin@connectify.rw',
        ], [
            'name' => 'Connectify Admin',
            'role' => UserRole::Admin,
            'country' => 'Rwanda',
            'city' => 'Kigali',
            'phone' => '+250788000000',
            'whatsapp_number' => '+250788000000',
            'password' => Hash::make('password'),
        ]);

        User::query()->updateOrCreate([
            'email' => 'buyer@connectify.rw',
        ], [
            'name' => 'Buyer Demo',
            'role' => UserRole::Buyer,
            'country' => 'Uganda',
            'city' => 'Kampala',
            'password' => Hash::make('password'),
        ]);

        $sellers = collect([$seller])->merge($this->createRegionalSellers());

        Listing::query()->create([
            'user_id' => $seller->id,
            'title' => 'Toyota Land Cruiser Prado TXL 2021',
            'slug' => 'toyota-land-cruiser-prado-txl-2021',
            'type' => ListingType::Vehicle,
            'transaction_type' => 'sale',
            'status' => ListingStatus::Published,
            'country' => 'Rwanda',
            'city' => 'Kigali',
            'area' => 'Nyarutarama',
            'price' => 48500000,
            'currency' => 'RWF',
            'contact_name' => $seller->name,
            'whatsapp_number' => $seller->whatsapp_number,
            'description' => 'One-owner SUV with full service history, leather interior and clean customs papers. Ready for city driving and upcountry trips across East Africa.',
            'cover_image' => 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=1400&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=1400&q=80',
                'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1400&q=80',
            ],
            'details' => [
                'condition' => 'Foreign used',
                'fuel' => 'Diesel',
                'transmission' => 'Automatic',
                'mileage' => '42,000 km',
            ],
            'highlights' => ['Sunroof', '7 seats', 'Reverse camera'],
            'is_featured' => true,
            'is_verified' => true,
            'published_at' => now(),
        ]);

        Listing::query()->create([
            'user_id' => $seller->id,
            'title' => '2 Bedroom Apartment in Kileleshwa',
            'slug' => '2-bedroom-apartment-kileleshwa',
            'type' => ListingType::Property,
            'transaction_type' => 'rent',
            'status' => ListingStatus::Published,
            'country' => 'Kenya',
            'city' => 'Nairobi',
            'area' => 'Kileleshwa',
            'price' => 1200,
            'currency' => 'USD',
            'contact_name' => $seller->name,
            'whatsapp_number' => $seller->whatsapp_number,
            'description' => 'Bright apartment with balcony, backup generator, gym access and secure parking in one of Nairobi\'s most convenient neighborhoods.',
            'cover_image' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1400&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1400&q=80',
                'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1400&q=80',
            ],
            'details' => [
                'bedrooms' => 2,
                'bathrooms' => 2,
                'furnishing' => 'Semi furnished',
                'tenure' => 'Monthly',
            ],
            'highlights' => ['Gym', 'Backup power', 'Secure parking'],
            'is_featured' => true,
            'is_verified' => true,
            'published_at' => now(),
        ]);

        Listing::query()->create([
            'user_id' => $seller->id,
            'title' => 'Senior Sales Executive - Kampala',
            'slug' => 'senior-sales-executive-kampala',
            'type' => ListingType::Job,
            'transaction_type' => 'hire',
            'status' => ListingStatus::Published,
            'country' => 'Uganda',
            'city' => 'Kampala',
            'area' => 'Kololo',
            'salary_min' => 1200,
            'salary_max' => 1800,
            'currency' => 'USD',
            'contact_name' => $seller->name,
            'whatsapp_number' => $seller->whatsapp_number,
            'description' => 'Lead B2B sales for a fast-growing commerce company serving Uganda, Rwanda and Tanzania. Strong regional network required.',
            'cover_image' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1400&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1400&q=80',
            ],
            'details' => [
                'employment_type' => 'Full time',
                'experience' => '4+ years',
                'workplace' => 'On site',
            ],
            'highlights' => ['Commission', 'Regional travel', 'Health cover'],
            'is_featured' => false,
            'is_verified' => true,
            'published_at' => now(),
        ]);

        Listing::query()->create([
            'user_id' => $seller->id,
            'title' => 'Professional Home Cleaning for Kigali Homes',
            'slug' => 'professional-home-cleaning-kigali-homes',
            'type' => ListingType::Service,
            'transaction_type' => 'service',
            'status' => ListingStatus::Published,
            'country' => 'Rwanda',
            'city' => 'Kigali',
            'area' => 'Kimihurura',
            'price' => 45,
            'currency' => 'USD',
            'contact_name' => $seller->name,
            'whatsapp_number' => $seller->whatsapp_number,
            'description' => 'Reliable weekly and one-off cleaning service for apartments, family homes and office spaces with same-day WhatsApp booking.',
            'cover_image' => 'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1400&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1400&q=80',
            ],
            'details' => [
                'availability' => 'Weekdays',
                'coverage' => 'City wide',
                'booking' => 'WhatsApp',
            ],
            'highlights' => ['Same day response', 'Trusted team', 'Flexible slots'],
            'is_featured' => true,
            'is_verified' => true,
            'published_at' => now(),
        ]);

        $seedTargets = [
            ListingType::Vehicle->value => 20,
            ListingType::Property->value => 20,
            ListingType::Job->value => 20,
            ListingType::Service->value => 20,
        ];

        foreach ($seedTargets as $typeValue => $targetCount) {
            $type = ListingType::from($typeValue);
            $existingCount = Listing::query()->where('type', $type)->count();
            $remaining = max(0, $targetCount - $existingCount);

            if ($remaining === 0) {
                continue;
            }

            Listing::factory()
                ->count($remaining)
                ->forType($type)
                ->recycle($sellers)
                ->create();
        }
    }

    private function createRegionalSellers(): Collection
    {
        return collect(MarketplaceOptions::countryOptions())
            ->map(function (string $country, int|string $key): User {
                $cities = array_keys(MarketplaceOptions::cityOptions($country));
                $city = $cities[array_rand($cities)];
                $slug = str($country)->lower()->replace(' ', '-');

                return User::query()->updateOrCreate([
                    'email' => 'seller-'.$slug.'@connectify.rw',
                ], [
                    'name' => fake()->name(),
                    'role' => UserRole::Seller,
                    'company_name' => fake()->company(),
                    'country' => $country,
                    'city' => $city,
                    'phone' => '+25078'.fake()->numerify('######'),
                    'whatsapp_number' => '+25078'.fake()->numerify('######'),
                    'bio' => 'Marketplace seller active in '.$country.' and ready to respond quickly on WhatsApp.',
                    'password' => Hash::make('password'),
                ]);
            })
            ->values();
    }
}
