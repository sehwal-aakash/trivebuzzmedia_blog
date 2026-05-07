<?php

namespace App\Domains\User\Repositories;

use App\Models\AuthorApplication;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AuthorApplicationRepository
{
    public function getPendingApplications(int $perPage = 15): LengthAwarePaginator
    {
        return AuthorApplication::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): AuthorApplication
    {
        return AuthorApplication::create($data);
    }

    public function find(int $id): ?AuthorApplication
    {
        return AuthorApplication::with('user')->find($id);
    }

    public function update(AuthorApplication $application, array $data): bool
    {
        return $application->update($data);
    }
}
