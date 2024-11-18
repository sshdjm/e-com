<?php

namespace App\Http\Controllers;

use App\Factories\PaymentGatewayFactory;
use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function createOrder(Request $request)
    {
        $user = Auth::user();

        return $this->paymentService->createOrder($user, $request);
    }

    public function handleWebhook(Request $request)
    {
        $user = Auth::user();

        return $this->paymentService->handleWebhook($request);
    }

}
