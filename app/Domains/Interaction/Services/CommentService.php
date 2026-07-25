<?php

namespace App\Domains\Interaction\Services;

use App\Domains\Interaction\Repositories\CommentRepository;
use App\Enums\CommentStatus;
use App\Models\Comment;
use App\Notifications\NewCommentNotification;

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

        $comment = $this->repository->create($data);

        // Notify post author
        $post = $comment->post;
        if ($post && $post->author && ($post->author_id !== ($data['user_id'] ?? null))) {
            $post->author->notify(new NewCommentNotification($comment));
        }

        return $comment;
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
