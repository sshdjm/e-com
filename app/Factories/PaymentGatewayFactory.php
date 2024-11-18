<?php

namespace App\Factories;

use App\PaymentGateway\PaymentGatewayInterface;
use App\PaymentGateway\YandexKassaGateway;

class PaymentGatewayFactory
{
    public static function create(string $gateway): PaymentGatewayInterface
    {
        switch ($gateway) {
            case 'paypal':
//                return new PayPalGateway();
            case 'stripe':
//                return new StripeGateway();
            case 'yandexkassa':
                return new YandexKassaGateway();
            default:
                throw new \InvalidArgumentException("Unknown payment gateway: $gateway");
        }
    }
}
