<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class SEOService
{
    public function generateTags(?Model $model = null, array $defaults = []): array
    {
        $seo = $model?->seoMeta;

        // Custom model specific SEO overrides
        $title = $defaults['title']
            ?? $seo?->title
            ?? $model?->meta_title
            ?? $model?->title
            ?? $model?->name
            ?? config('app.name', 'TriveBuzz Media');

        $description = $defaults['description']
            ?? $seo?->description
            ?? $model?->meta_description
            ?? $model?->excerpt
            ?? $model?->description
            ?? 'Discover breaking news, tech insights, lifestyle articles, and expert stories on TriveBuzz Media.';

        $keywords = $defaults['keywords']
            ?? $seo?->keywords
            ?? $model?->meta_keywords
            ?? 'trivebuzz, blog, news, articles, publishing, stories';

        $robots = $defaults['robots'] ?? $seo?->robots ?? 'index, follow';

        $ogTitle = $seo?->og_title ?? $title;
        $ogDescription = $seo?->og_description ?? $description;
        $ogImage = $seo?->og_image ?? $model?->featured_image ?? $defaults['og_image'] ?? asset('trivebuzzmedia-logo.png');

        if ($ogImage && ! str_starts_with($ogImage, 'http') && ! str_contains($ogImage, 'trivebuzzmedia-logo.png')) {
            $ogImage = asset('storage/'.$ogImage);
        }

        $schemaType = 'WebPage';
        if ($model instanceof Post) {
            $schemaType = 'BlogPosting';
        } elseif ($model instanceof Category || $model instanceof Tag) {
            $schemaType = 'CollectionPage';
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => $schemaType,
            'headline' => $title,
            'description' => $description,
            'image' => $ogImage ?: asset('images/default-og.jpg'),
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name', 'TriveBuzz Media'),
                'url' => config('app.url'),
            ],
            'datePublished' => $model?->published_at?->toIso8601String() ?? $model?->created_at?->toIso8601String(),
            'dateModified' => $model?->updated_at?->toIso8601String() ?? now()->toIso8601String(),
        ];

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'robots' => $robots,
            'og_title' => $ogTitle,
            'og_description' => $ogDescription,
            'og_image' => $ogImage,
            'twitter_card' => $seo?->twitter_card ?? 'summary_large_image',
            'canonical_url' => $seo?->canonical_url ?? Request::url(),
            'schema' => $schema,
        ];
    }
}
