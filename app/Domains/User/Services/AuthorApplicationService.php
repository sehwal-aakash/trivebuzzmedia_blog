<?php

namespace App\Domains\User\Services;

use App\Domains\User\Repositories\AuthorApplicationRepository;
use App\Domains\User\Repositories\UserRepository;
use App\Enums\AuthorApplicationStatus;
use App\Enums\UserRole;
use App\Models\AuthorApplication;
use App\Models\User;
use App\Notifications\AuthorApplicationApproved;
use App\Notifications\AuthorApplicationRejected;

class AuthorApplicationService
{
    public function __construct(
        protected AuthorApplicationRepository $applicationRepository,
        protected UserRepository $userRepository
    ) {}

    public function submitApplication(User $user, array $data): AuthorApplication
    {
        return $this->applicationRepository->create([
            'user_id' => $user->id,
            'bio' => $data['bio'],
            'portfolio_links' => $data['portfolio_links'] ?? [],
            'status' => AuthorApplicationStatus::PENDING,
        ]);
    }

    public function approveApplication(AuthorApplication $application): bool
    {
        $this->applicationRepository->update($application, [
            'status' => AuthorApplicationStatus::APPROVED,
        ]);

        $user = $application->user;
        $this->userRepository->updateRole($user, UserRole::APPROVED_AUTHOR);

        $user->notify(new AuthorApplicationApproved);

        return true;
    }

    public function rejectApplication(AuthorApplication $application, string $reason = ''): bool
    {
        $this->applicationRepository->update($application, [
            'status' => AuthorApplicationStatus::REJECTED,
        ]);

        $application->user->notify(new AuthorApplicationRejected($reason));

        return true;
    }
}
