<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Post $post): bool
    {
        if ($post->status->value === 'published') {
            return true;
        }

        return $user?->id === $post->author_id || $user?->isAdmin() || $user?->isEditor();
    }

    public function create(User $user): bool
    {
        return $user->isAuthor() || $user->isAdmin() || $user->isEditor();
    }

    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->author_id || $user->isAdmin() || $user->isEditor();
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->author_id || $user->isAdmin();
    }

    public function publish(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }
}
