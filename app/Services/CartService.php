<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\User;
use Illuminate\Http\Request;
class CartService
{
    public function addItem(User $user, $productId)
    {
        $cart = $user->cart()->firstOrCreate([]);

        $cartItem = $cart->items()->firstOrCreate([
            'product_id' => $productId,
        ]);

        return $cartItem;
    }

    public function removeCartItem(int $cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);

        if (!$cartItem) {
            return ['message' => 'Cart item not found', 'status' => 404];
        }

        $cartItem->delete();

        return ['message' => 'Cart item removed', 'status' => 200];
    }

    public function getCart(User $user)
    {
        if (!$user->cart) {
            return ['message' => 'Cart not found', 'status' => 404];
        }

        $cart = $user->cart->load('items.product');
        $amount = $cart->total();

        return ['cart' => $cart, 'amount' => $amount, 'status' => 200];
    }

}