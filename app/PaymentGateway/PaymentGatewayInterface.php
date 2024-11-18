<?php

namespace App\PaymentGateway;

interface PaymentGatewayInterface
{
    public function getPaymentLink(array $data): string;
}