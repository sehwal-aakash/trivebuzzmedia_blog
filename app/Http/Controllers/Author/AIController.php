<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Services\AIContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AIController extends Controller
{
    public function __construct(
        protected AIContentService $aiService
    ) {}

    public function generateOutline(Request $request): JsonResponse
    {
        $request->validate(['topic' => 'required|string|max:255']);
        $outline = $this->aiService->generateOutline($request->topic);

        return response()->json(['content' => $outline]);
    }

    public function generateTitles(Request $request): JsonResponse
    {
        $request->validate(['topic' => 'required|string|max:255']);
        $titles = $this->aiService->generateTitle($request->topic);

        return response()->json(['content' => $titles]);
    }

    public function generateSummary(Request $request): JsonResponse
    {
        $request->validate(['content' => 'required|string']);
        $summary = $this->aiService->generateSummary($request->content);

        return response()->json(['content' => $summary]);
    }

    public function suggestKeywords(Request $request): JsonResponse
    {
        $request->validate(['topic' => 'required|string|max:255']);
        $keywords = $this->aiService->suggestKeywords($request->topic);

        return response()->json(['content' => $keywords]);
    }
}
