<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'username', 'password', 'role', 'phone', 'google_id', 'avatar_path', 'email_verified_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function isAgentOrLandlord(): bool
    {
        return in_array($this->role, ['agent', 'landlord']);
    }

    public function activeSubscription(): ?Subscription
    {
        return $this->subscriptions()->active()->latest()->first();
    }

    public function listingLimit(): int
    {
        return $this->activeSubscription()?->listingLimit() ?? 0;
    }

    public function activeListingCount(): int
    {
        return $this->properties()->whereIn('status', ['pending', 'published'])->count();
    }

    public function canCreateListing(): bool
    {
        return $this->activeListingCount() < $this->listingLimit();
    }

    public function avatarUrl(): string
    {
        if (! $this->avatar_path) {
            return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=123A6B&color=fff';
        }

        if (str_starts_with($this->avatar_path, 'http')) {
            return $this->avatar_path;
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->url($this->avatar_path);
    }
}
