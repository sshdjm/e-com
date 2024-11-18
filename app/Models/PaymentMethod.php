<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function generatePaymentUrl($orderId,$amount)
    {
        switch ($this->name) {
            case 'PayPal':
                return $this->generatePayPalUrl($orderId,$amount);
            case 'Stripe':
                return $this->generateStripeUrl($orderId,$amount);
            case 'Yandex':
                return $this->generateYandexUrl($orderId,$amount);
            default:
                throw new \InvalidArgumentException("Unknown payment method: {$this->name}");
        }
    }

    private function generatePayPalUrl($orderId, $amount)
    {
        return str_replace([':orderId', ':amount'], [$orderId, $amount], 'https://www.paypal.com/pay/:orderId?amount=:amount');
    }

    private function generateStripeUrl($orderId, $amount)
    {
        return str_replace([':orderId', ':amount'], [$orderId, $amount], 'https://checkout.stripe.com/:orderId?amount=:amount');
    }

    private function generateYandexUrl($orderId, $amount)
    {
        return str_replace([':orderId', ':amount'], [$orderId, $amount], 'https://yoomoney.ru/pay/:orderId?amount=:amount');
    }



}
