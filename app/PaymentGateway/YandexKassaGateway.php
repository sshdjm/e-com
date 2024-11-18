<?php

namespace App\PaymentGateway;

use App\PaymentGateway\PaymentGatewayInterface;

class YandexKassaGateway implements PaymentGatewayInterface
{

    public function getPaymentLink(array $data): string
    {
        $amount = $data['amount'];
        $itemId = $data['item_id'];

        return "https://money.yandex.ru/payment/?amount=$amount&order_id=$itemId";
    }


}