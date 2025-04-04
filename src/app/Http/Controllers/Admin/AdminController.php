<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display users with their products
     */
    public function usersWithProducts()
    {
        $users = User::with(['products' => function($query) {
                $query->select('id', 'title', 'user_id');
            }])
            ->select('id', 'name', 'email')
            ->whereHas('products')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }
}