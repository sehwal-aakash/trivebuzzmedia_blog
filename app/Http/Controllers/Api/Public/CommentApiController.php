<?php

namespace App\Http\Controllers\Api\Public;

use App\Domains\Interaction\Services\CommentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Interaction\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use Illuminate\Http\JsonResponse;

class CommentApiController extends Controller
{
    public function __construct(
        protected CommentService $commentService
    ) {}

    public function store(StoreCommentRequest $request): JsonResponse
    {
        $data = $request->validated();
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        $comment = $this->commentService->createComment($data);

        return response()->json([
            'message' => 'Comment submitted successfully and pending moderation.',
            'data' => new CommentResource($comment),
        ], 201);
    }
}
