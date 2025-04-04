<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('home', compact('products'));
    }
}
