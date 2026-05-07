<?php

namespace App\Domains\User\Repositories;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function updateRole(User $user, UserRole $role): bool
    {
        return $user->update(['role' => $role]);
    }

    public function getByRole(UserRole $role, int $perPage = 15): LengthAwarePaginator
    {
        return User::where('role', $role)->paginate($perPage);
    }
}
