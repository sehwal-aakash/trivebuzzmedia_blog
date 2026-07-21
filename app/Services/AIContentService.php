<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIContentService
{
    protected string $apiKey;

    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', '');
        $model = config('services.gemini.model', 'gemini-1.5-flash');
        $this->baseUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";
    }

    public function generateOutline(string $topic): ?string
    {
        $prompt = "You are an expert content strategist. Generate a detailed, SEO-optimized blog post outline for the topic: '{$topic}'. 
        Structure the response with a compelling introduction hook, 4-6 main body sections with descriptive H2 subheadings, bullet points for key talking points under each section, and a strong conclusion with a call-to-action.";

        return $this->callGemini($prompt);
    }

    public function generateTitle(string $topic): ?string
    {
        $prompt = "You are an expert copywriter. Generate 5 high-CTR, SEO-friendly blog post titles for the topic: '{$topic}'. 
        Include a mix of listicles, 'how-to' guides, and curiosity-driven titles. Return ONLY the titles as a numbered list.";

        return $this->callGemini($prompt);
    }

    public function generateSummary(string $content): ?string
    {
        $contentPreview = substr(strip_tags($content), 0, 2000);
        $prompt = "You are an SEO specialist. Write a compelling meta description (150-160 characters) that summarizes the following blog content and encourages clicks: \n\n {$contentPreview}";

        return $this->callGemini($prompt);
    }

    public function suggestKeywords(string $topic): ?string
    {
        $prompt = "You are an SEO researcher. Suggest 10 high-volume, relevant SEO keywords and long-tail phrases for a blog post about: '{$topic}'. 
        Return them ONLY as a comma-separated list.";

        return $this->callGemini($prompt);
    }

    protected function callGemini(string $prompt): ?string
    {
        if (empty($this->apiKey)) {
            Log::warning('Gemini API key is not configured. Returning mock response.');

            return 'Mock AI response for: '.substr($prompt, 0, 50).'...';
        }

        try {
            $response = Http::post("{$this->baseUrl}?key={$this->apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
            ]);

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text');
            }

            Log::error('Gemini API Error: '.$response->body());

            return null;
        } catch (\Exception $e) {
            Log::error('Gemini API Exception: '.$e->getMessage());

            return null;
        }
    }
}
