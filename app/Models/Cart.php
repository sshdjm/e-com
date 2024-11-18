<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_items');

    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }


    public function total(){
        return $this->items->sum('product.price');
    }

}
