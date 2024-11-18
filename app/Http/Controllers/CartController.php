<?php

namespace App\Http\Controllers;


use App\Models\Cart;

use App\Models\Order;

use App\Models\PaymentMethod;
use App\Services\CartService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class CartController extends Controller
{

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addItem(Request $request)
    {
        $user = Auth::user();
        $productId = $request->input('product_id');

        $cartItem = $this->cartService->addItem($user, $productId);

        return response()->json($cartItem, 201);
    }

    public function removeItem(int $cartItemId)
    {
        $result = $this->cartService->removeCartItem($cartItemId);

        return response()->json(['message' => $result['message']], $result['status']);
    }

    public function getCart(Request $request)
    {
        $user = Auth::user();
        $result = $this->cartService->getCart($user);

        if ($result['status'] === 404) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['cart' => $result['cart'], 'amount' => $result['amount']]);
    }


}
