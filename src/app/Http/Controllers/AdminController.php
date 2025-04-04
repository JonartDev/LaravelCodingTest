<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function usersWithProducts()
    {
        $users = User::with(['products' => function($query) {
                $query->select('id', 'title', 'user_id');
            }])
            ->select('id', 'name', 'email')
            ->whereHas('products')
            ->paginate(10);
            
        return view('admin.users.index', compact('users'));
    }
    
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.list', compact('users'));
    }
    
    public function show(User $user)
    {
        $user->load('products');
        return view('admin.users.show', compact('user'));
    }
}