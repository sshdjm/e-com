<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    public function getAllProducts(Request $request)
    {
        $sortOrder = $request->get('sort', 'asc'); // По умолчанию сортируем по возрастанию
        $sortBy = $request->input('sortBy', 'price'); // По умолчанию сортируем по цене

        return Product::orderBy($sortBy, $sortOrder)->get();
    }
    public function getProductById(string $id)
    {
        return Product::find($id);
    }
}