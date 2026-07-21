<?php

namespace App\Http\Controllers\Api\Admin;

use App\Domains\User\Services\AuthorApplicationService;
use App\Http\Controllers\Controller;
use App\Models\AuthorApplication;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminApiController extends Controller
{
    public function __construct(
        protected AuthorApplicationService $applicationService
    ) {}

    public function dashboard(): JsonResponse
    {
        return response()->json([
            'stats' => [
                'total_users' => User::count(),
                'total_posts' => Post::count(),
                'pending_applications' => AuthorApplication::pending()->count(),
                'pending_comments' => Comment::pending()->count(),
            ],
        ]);
    }

    public function approveAuthor(AuthorApplication $application): JsonResponse
    {
        $this->applicationService->approveApplication($application);

        return response()->json([
            'message' => 'Author application approved successfully.',
        ]);
    }

    public function rejectAuthor(AuthorApplication $application): JsonResponse
    {
        $this->applicationService->rejectApplication($application);

        return response()->json([
            'message' => 'Author application rejected.',
        ]);
    }
}
