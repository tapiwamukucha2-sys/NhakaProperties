<?php

namespace App\Support;

class SubscriptionPlans
{
    public static function all(): array
    {
        return [
            'starter' => [
                'name' => 'Starter',
                'price' => 5,
                'period' => 'month',
                'listing_limit' => 2,
                'desc' => 'For a landlord with one or two properties to fill.',
                'features' => ['Up to 2 active listings', 'WhatsApp inquiry forwarding', 'Basic listing analytics'],
            ],
            'agent' => [
                'name' => 'Agent',
                'price' => 18,
                'period' => 'month',
                'listing_limit' => 25,
                'desc' => 'For agents actively managing a portfolio.',
                'features' => ['Up to 25 active listings', 'Featured placement rotation', 'Verified agent badge', 'Lead inbox with reply tracking'],
                'featured' => true,
            ],
            'developer' => [
                'name' => 'Developer',
                'price' => null,
                'period' => null,
                'listing_limit' => 999999,
                'desc' => 'For new developments and large agencies.',
                'features' => ['Unlimited listings', 'Dedicated project page', 'Homepage & category placement', 'Account manager'],
            ],
        ];
    }

    public static function find(string $key): ?array
    {
        return static::all()[$key] ?? null;
    }
}
