<?php

namespace App\Models;

use App\Support\SubscriptionPlans;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'plan', 'status', 'method', 'amount', 'reference', 'note', 'approved_at', 'expires_at'])]
class Subscription extends Model
{
    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()));
    }

    public function planDetails(): ?array
    {
        return SubscriptionPlans::find($this->plan);
    }

    public function listingLimit(): int
    {
        return $this->planDetails()['listing_limit'] ?? 0;
    }
}
