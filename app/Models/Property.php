<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable([
    'user_id', 'title', 'slug', 'description', 'category', 'status', 'price', 'price_period',
    'location', 'province', 'bedrooms', 'bathrooms', 'size_sqm', 'images', 'is_verified',
])]
class Property extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (Property $property) {
            if (! $property->slug) {
                $base = Str::slug($property->title);
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $base.'-'.(++$i);
                }
                $property->slug = $slug;
            }
        });
    }

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_verified' => 'boolean',
            'is_featured' => 'boolean',
            'images' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function imageUrls(): array
    {
        return collect($this->images ?? [])
            ->map(fn ($path) => str_starts_with($path, 'images/')
                ? asset($path)
                : \Illuminate\Support\Facades\Storage::disk('public')->url($path))
            ->all();
    }

    public function metaSummary(): array
    {
        $meta = [];

        if ($this->bedrooms) {
            $meta[] = $this->bedrooms.' bed';
        }

        if ($this->bathrooms) {
            $meta[] = $this->bathrooms.' bath';
        }

        if ($this->size_sqm) {
            $meta[] = number_format($this->size_sqm).'m²';
        }

        return $meta ?: ['Details on request'];
    }

    public function displayPrice(): string
    {
        return '$'.number_format((float) $this->price).($this->price_period === 'month' ? ' / mo' : '');
    }
}
