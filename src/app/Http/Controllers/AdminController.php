<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller
{
    public function usersWithProducts()
    {
        $users = User::with('products')->get();
        return view('admin.users.index', compact('users'));
    }
    
}