<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products/{id}', [AdminProductController::class, 'show']);

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'show'])->name('register'); // Show register form
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/products/{product}/details', function (Product $product) {
        return response()->json([
            'title' => $product->title,
            'body' => $product->body,
            'quantity' => $product->quantity,
            'image_path' => $product->image_path,
            'user' => [
                'name' => $product->user->name
            ]
        ]);
    });
});

// Authenticated routes
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/products/create', function () {
        return view('products.create');
    })->middleware('auth')->name('products.create');
    Route::get('/products/{product}', [AdminProductController::class, 'show'])->name('products.show');
    // User dashboard

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        // routes/web.php

        // Admin product management
        Route::resource('products', AdminProductController::class)->except(['show']);

        // Admin user management
        Route::resource('users', UserController::class);
        Route::get('/users-with-products', [UserController::class, 'usersWithProducts'])
            ->name('users.with-products');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    });
});
