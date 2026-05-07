<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class SEOService
{
    public function generateTags(?Model $model = null, array $defaults = []): array
    {
        $seo = $model?->seoMeta;

        $title = $seo?->title ?? $model?->title ?? $model?->name ?? $defaults['title'] ?? config('app.name');
        $description = $seo?->description ?? $model?->excerpt ?? $model?->description ?? $defaults['description'] ?? '';
        $keywords = $seo?->keywords ?? $defaults['keywords'] ?? '';

        $ogTitle = $seo?->og_title ?? $title;
        $ogDescription = $seo?->og_description ?? $description;
        $ogImage = $seo?->og_image ?? $model?->featured_image ?? $defaults['og_image'] ?? '';

        if ($ogImage && ! str_starts_with($ogImage, 'http')) {
            $ogImage = asset('storage/'.$ogImage);
        }

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'og_title' => $ogTitle,
            'og_description' => $ogDescription,
            'og_image' => $ogImage,
            'twitter_card' => $seo?->twitter_card ?? 'summary_large_image',
            'canonical_url' => $seo?->canonical_url ?? Request::url(),
        ];
    }
}
