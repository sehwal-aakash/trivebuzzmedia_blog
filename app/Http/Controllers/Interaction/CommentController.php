<?php

namespace App\Http\Controllers\Interaction;

use App\Domains\Interaction\Services\CommentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Interaction\StoreCommentRequest;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function __construct(
        protected CommentService $commentService
    ) {}

    public function store(StoreCommentRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        $this->commentService->createComment($data);

        return back()->with('success', 'Comment submitted successfully. It will be visible after approval.');
    }
}
