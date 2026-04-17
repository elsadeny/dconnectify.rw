<?php

namespace App\Models;

use App\Enums\ListingStatus;
use App\Enums\ListingType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable([
    'user_id',
    'title',
    'slug',
    'type',
    'transaction_type',
    'status',
    'country',
    'city',
    'area',
    'price',
    'salary_min',
    'salary_max',
    'currency',
    'description',
    'contact_name',
    'whatsapp_number',
    'cover_image',
    'gallery',
    'details',
    'highlights',
    'is_featured',
    'is_verified',
    'published_at',
])]
class Listing extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'type' => ListingType::class,
            'status' => ListingStatus::class,
            'gallery' => 'array',
            'details' => 'array',
            'highlights' => 'array',
            'is_featured' => 'boolean',
            'is_verified' => 'boolean',
            'published_at' => 'datetime',
            'price' => 'decimal:2',
            'salary_min' => 'decimal:2',
            'salary_max' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Listing $listing): void {
            if (blank($listing->slug)) {
                $listing->slug = Str::slug($listing->title);
            }
        });
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', ListingStatus::Published)
            ->whereNotNull('published_at');
    }

    public function formattedPrimaryValue(): string
    {
        if ($this->type === ListingType::Job && ($this->salary_min || $this->salary_max)) {
            return trim(collect([$this->salary_min, $this->salary_max])
                ->filter()
                ->map(fn ($value) => number_format((float) $value))
                ->implode(' - ')).' '.$this->currency;
        }

        if ($this->price) {
            return number_format((float) $this->price).' '.$this->currency;
        }

        return 'Contact for price';
    }

    public function whatsappUrl(): string
    {
        $number = preg_replace('/[^0-9]/', '', (string) $this->whatsapp_number);

        return 'https://wa.me/'.$number.'?text='.urlencode('Hello, I am interested in '.$this->title.' on Connectify.');
    }
}