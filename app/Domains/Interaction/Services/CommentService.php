<?php

namespace App\Domains\Interaction\Services;

use App\Domains\Interaction\Repositories\CommentRepository;
use App\Enums\CommentStatus;
use App\Models\Comment;

class CommentService
{
    public function __construct(
        protected CommentRepository $repository
    ) {}

    public function createComment(array $data): Comment
    {
        // For now, auto-approve comments from registered users
        // Guests comments are pending by default
        if (isset($data['user_id'])) {
            $data['status'] = CommentStatus::APPROVED;
        } else {
            $data['status'] = CommentStatus::PENDING;
        }

        return $this->repository->create($data);
    }

    public function approveComment(Comment $comment): bool
    {
        return $this->repository->update($comment, ['status' => CommentStatus::APPROVED]);
    }

    public function markAsSpam(Comment $comment): bool
    {
        return $this->repository->update($comment, ['status' => CommentStatus::SPAM]);
    }
}
