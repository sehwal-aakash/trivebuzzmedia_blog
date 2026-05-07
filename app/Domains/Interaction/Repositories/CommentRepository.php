<?php

namespace App\Domains\Interaction\Repositories;

use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CommentRepository
{
    public function getCommentsForPost(int $postId, int $perPage = 20): LengthAwarePaginator
    {
        return Comment::where('post_id', $postId)
            ->with('user')
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public function find(int $id): ?Comment
    {
        return Comment::find($id);
    }

    public function update(Comment $comment, array $data): bool
    {
        return $comment->update($data);
    }

    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }
}
