<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = User::with('role')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function usersWithProducts()
    {
        $users = $this->userService->getUsersWithProducts();
        return view('admin.users.with-products', compact('users'));
    }

    public function create()
    {
        $roles = UserRole::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Requires password_confirmation
            'role_id' => 'required|exists:user_roles,id'
        ]);

        $this->userService->createUser($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed', // Requires password_confirmation when present
            'role_id' => 'required|exists:user_roles,id'
        ]);

        $this->userService->updateUser($user, $validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }
    public function edit(User $user)
    {
        $roles = UserRole::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function destroy(User $user)
    {
        if (!$this->userService->deleteUser($user)) {
            return back()->with('error', 'You cannot delete your own account');
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
    public function show(User $user)
    {
        $user->load('products');
        return view('admin.users.show', compact('user'));
    }
}
