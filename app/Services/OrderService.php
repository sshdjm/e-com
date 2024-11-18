<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function getOrdersForUser(array $params)
    {
        $user = Auth::user();

        $sortBy = $params['sortBy'] ?? 'created_at'; // Default sort by created_at
        $sortOrder = $params['sort'] ?? 'desc'; // Default sort order is descending
        $status = $params['status'] ?? null;

        $query = $user->orders();

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy($sortBy, $sortOrder)->get();
    }
}