<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'] ?? UserRole::CUSTOMER
        ]);
    }

    public function updateUser(User $user, array $data): User
    {
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id']
        ];

        // Only update password if it was provided
        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);
        return $user;
    }

    public function deleteUser(User $user): bool
    {
        // Prevent admin from deleting themselves
        if (auth()->id() === $user->id) {
            return false;
        }

        return $user->delete();
    }

    public function getUsersWithProducts()
    {
        return User::with(['products' => function ($query) {
            $query->select('id', 'title', 'user_id');
        }])
            ->whereHas('products')
            ->paginate(10);
    }
}
