<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function listUsers(array $filters, User $authenticatedUser): LengthAwarePaginator
    {
        $query = User::query();

        if ($authenticatedUser->isDev()) {
            $query->where('parent_id', $authenticatedUser->id);
        }

        if (!empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate(15)->withQueryString();
    }

    public function createUser(array $data, User $creator): array
    {
        $tempPassword = Str::random(8);
        
        $role = $creator->isDev() ? 'client' : ($data['role'] ?? 'client');
        $parentId = $creator->isDev() ? $creator->id : null;

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'] ?? null,
            'password' => Hash::make($tempPassword),
            'role' => $role,
            'parent_id' => $parentId,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        return [
            'user' => $user,
            'temp_password' => $tempPassword
        ];
    }

    public function updateUser(User $user, array $data, User $editor): User
    {
        if ($editor->isDev()) {
            unset($data['role']);
        }

        $user->update($data);
        
        return $user;
    }

    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }
}