<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommentStatus;
use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['user', 'post'])->latest()->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => CommentStatus::APPROVED]);

        return back()->with('success', 'Comment approved successfully.');
    }

    public function reject(Comment $comment)
    {
        $comment->update(['status' => CommentStatus::REJECTED]);

        return back()->with('success', 'Comment rejected successfully.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
