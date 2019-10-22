<?php


namespace App\Services;


use Stripe\Charge;
use Stripe\Stripe;

class StripeHandler
{
    public function __construct(string $stripePrivateKey)
    {
        Stripe::setApiKey($stripePrivateKey);
    }

    public function charge(int $amount, string $token)
    {
        Charge::create([
            'amount' => $amount,
            'currency' => 'eur',
            'description' => 'Example charge',
            'source' => $token,
        ]);
    }
}