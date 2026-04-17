<?php

namespace Database\Factories;

use App\Enums\ListingStatus;
use App\Enums\ListingType;
use App\Enums\UserRole;
use App\Models\Listing;
use App\Models\User;
use App\Support\MarketplaceOptions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Listing>
 */
class ListingFactory extends Factory
{
    protected $model = Listing::class;

    public function definition(): array
    {
        $type = fake()->randomElement(ListingType::cases());
        $country = fake()->randomElement(array_keys(MarketplaceOptions::countryOptions()));
        $city = fake()->randomElement(array_keys(MarketplaceOptions::cityOptions($country)));

        return [
            'user_id' => User::factory()->state([
                'role' => UserRole::Seller,
                'company_name' => fake()->company(),
                'country' => $country,
                'city' => $city,
                'phone' => '+25078'.fake()->numerify('######'),
                'whatsapp_number' => '+25078'.fake()->numerify('######'),
            ]),
            'status' => ListingStatus::Published,
            'country' => $country,
            'city' => $city,
            'area' => fake()->streetName(),
            'currency' => fake()->randomElement(['RWF', 'USD', 'KES', 'UGX', 'TZS']),
            'contact_name' => fake()->name(),
            'whatsapp_number' => '+25078'.fake()->numerify('######'),
            'is_featured' => false,
            'is_verified' => fake()->boolean(75),
            'published_at' => fake()->dateTimeBetween('-60 days', 'now'),
            ...$this->payloadForType($type),
        ];
    }

    public function forType(ListingType $type): static
    {
        return $this->state(function (array $attributes) use ($type): array {
            return $this->payloadForType($type);
        });
    }

    private function payloadForType(ListingType $type): array
    {
        return match ($type) {
            ListingType::Vehicle => $this->vehiclePayload(),
            ListingType::Property => $this->propertyPayload(),
            ListingType::Job => $this->jobPayload(),
            ListingType::Service => $this->servicePayload(),
        };
    }

    private function vehiclePayload(): array
    {
        $brand = fake()->randomElement(['Toyota', 'Nissan', 'Mercedes-Benz', 'Subaru', 'Volkswagen', 'Suzuki']);
        $model = fake()->randomElement(['Land Cruiser Prado', 'X-Trail', 'C200', 'Forester', 'Amarok', 'Vitara']);
        $year = fake()->numberBetween(2017, 2024);
        $title = $brand.' '.$model.' '.$year;
        $cover = fake()->randomElement([
            'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=1400&q=80',
            'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1400&q=80',
            'https://images.unsplash.com/photo-1549924231-f129b911e442?auto=format&fit=crop&w=1400&q=80',
        ]);

        return [
            'title' => $title,
            'slug' => Str::slug($title.' '.fake()->unique()->numerify('###')),
            'type' => ListingType::Vehicle,
            'transaction_type' => fake()->randomElement(['sale', 'rent']),
            'price' => fake()->numberBetween(8500000, 68000000),
            'salary_min' => null,
            'salary_max' => null,
            'description' => fake()->sentence(18).' '.fake()->sentence(14).' Suitable for city driving, family use and regional travel.',
            'cover_image' => $cover,
            'gallery' => [
                $cover,
                'https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=1400&q=80',
            ],
            'details' => [
                'condition' => fake()->randomElement(['Foreign used', 'Locally used', 'New']),
                'fuel' => fake()->randomElement(['Petrol', 'Diesel', 'Hybrid']),
                'transmission' => fake()->randomElement(['Automatic', 'Manual']),
                'mileage' => fake()->numberBetween(12000, 140000).' km',
            ],
            'highlights' => fake()->randomElements(['Reverse camera', 'Leather interior', 'Sunroof', 'Bluetooth', 'Alloy wheels'], 3),
        ];
    }

    private function propertyPayload(): array
    {
        $bedrooms = fake()->numberBetween(1, 5);
        $propertyType = fake()->randomElement(['Apartment', 'House', 'Studio', 'Office Suite']);
        $title = $bedrooms.' Bedroom '.$propertyType.' in '.fake()->randomElement(['Prime Area', 'City Center', 'Secure Estate', 'Business District']);
        $cover = fake()->randomElement([
            'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1400&q=80',
            'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1400&q=80',
            'https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1400&q=80',
        ]);
        $transactionType = fake()->randomElement(['sale', 'rent']);

        return [
            'title' => $title,
            'slug' => Str::slug($title.' '.fake()->unique()->numerify('###')),
            'type' => ListingType::Property,
            'transaction_type' => $transactionType,
            'price' => $transactionType === 'rent'
                ? fake()->numberBetween(450, 3200)
                : fake()->numberBetween(45000, 380000),
            'salary_min' => null,
            'salary_max' => null,
            'description' => fake()->sentence(18).' '.fake()->sentence(16).' Located close to transport, schools and daily essentials.',
            'cover_image' => $cover,
            'gallery' => [
                $cover,
                'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1400&q=80',
            ],
            'details' => [
                'bedrooms' => $bedrooms,
                'bathrooms' => fake()->numberBetween(1, 4),
                'furnishing' => fake()->randomElement(['Unfurnished', 'Semi furnished', 'Furnished']),
                'tenure' => $transactionType === 'rent' ? 'Monthly' : 'For sale',
            ],
            'highlights' => fake()->randomElements(['Balcony', 'Parking', 'Backup power', 'Security', 'Water tank'], 3),
        ];
    }

    private function jobPayload(): array
    {
        $role = fake()->randomElement(['Sales Executive', 'Operations Manager', 'Marketing Officer', 'Accountant', 'Driver', 'Customer Support Lead']);
        $cover = 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1400&q=80';
        $salaryMin = fake()->numberBetween(400, 1800);
        $salaryMax = $salaryMin + fake()->numberBetween(150, 1200);

        return [
            'title' => $role.' - '.fake()->randomElement(['Immediate Start', 'Regional Team', 'Growth Role', 'Full Time']),
            'slug' => Str::slug($role.' '.fake()->unique()->numerify('###')),
            'type' => ListingType::Job,
            'transaction_type' => 'hire',
            'price' => null,
            'salary_min' => $salaryMin,
            'salary_max' => $salaryMax,
            'description' => fake()->sentence(18).' '.fake()->sentence(14).' Applicants should be ready to work with customers, teams and fast-moving targets.',
            'cover_image' => $cover,
            'gallery' => [$cover],
            'details' => [
                'employment_type' => fake()->randomElement(['Full time', 'Part time', 'Contract']),
                'experience' => fake()->randomElement(['1+ years', '2+ years', '4+ years']),
                'workplace' => fake()->randomElement(['On site', 'Hybrid', 'Remote']),
            ],
            'highlights' => fake()->randomElements(['Health cover', 'Transport allowance', 'Commission', 'Training'], 3),
        ];
    }

    private function servicePayload(): array
    {
        $service = fake()->randomElement(['Home cleaning', 'Moving service', 'Graphic design', 'Event photography', 'Plumbing', 'Car detailing']);
        $cover = fake()->randomElement([
            'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1400&q=80',
            'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1400&q=80',
            'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=1400&q=80',
        ]);

        return [
            'title' => $service.' for homes and businesses',
            'slug' => Str::slug($service.' '.fake()->unique()->numerify('###')),
            'type' => ListingType::Service,
            'transaction_type' => 'service',
            'price' => fake()->numberBetween(25, 1500),
            'salary_min' => null,
            'salary_max' => null,
            'description' => fake()->sentence(18).' '.fake()->sentence(15).' Ideal for clients looking for reliable delivery, quick turnaround and verified providers.',
            'cover_image' => $cover,
            'gallery' => [$cover],
            'details' => [
                'availability' => fake()->randomElement(['Weekdays', 'Weekends', 'Same day']),
                'coverage' => fake()->randomElement(['City wide', 'Regional', 'Nationwide']),
                'booking' => fake()->randomElement(['WhatsApp', 'Call', 'In-app enquiry']),
            ],
            'highlights' => fake()->randomElements(['Fast response', 'Verified provider', 'Flexible pricing', 'On-site support'], 3),
        ];
    }
}