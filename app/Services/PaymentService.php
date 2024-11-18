<?php

namespace App\Services;


use App\Models\Order;
use App\Models\User;
use App\Factories\PaymentGatewayFactory;
use Illuminate\Http\Request;

class PaymentService
{
    public function createOrder(User $user, Request $request)
    {
        $cart = $user->cart;
        $amount = $cart->total();

        if (!$cart) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $gatewayType = $request->input('gateway', 'yandexkassa'); // Можно 'stripe', 'yandexkassa'

        $order = Order::create([
            'user_id' => $user->id,
            'payment_method' => $gatewayType,
            'status' => 'На оплату',
            'amount' => $amount,
        ]);

        $order->items()->createMany(
            $cart->items->map->toArray()
        );

        $paymentData = [
            'amount' => $amount,
            'item_id' => $order->id,
            'description' => 'Оплата заказа',
        ];

        $gateway = PaymentGatewayFactory::create($gatewayType);
        $paymentLink = $gateway->getPaymentLink($paymentData);


        $cart->delete();

        return response()->json(['payment_link' => $paymentLink]);
    }

    public function handleWebhook(Request $request)
    {
        $data = $request->all();

        // Проверка данных и подтверждение оплаты
        if ($data['status'] === 'COMPLETED') {
            $orderId = $data['orderId'];
            $this->updateOrderStatus($orderId, 'Оплачен');
        }

        return response()->json(['message' => 'Webhook received'], 200);
    }

    private function updateOrderStatus($orderId, $status)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = $status;
            $order->save();
        }
    }

}