<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Traits\HasSEO;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory, HasSEO;

    protected $fillable = [
        'author_id',
        'category_id',
        'featured_image',
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'published_at',
        'is_sponsored',
        'affiliate_link',
        'view_count',
    ];

    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
            'published_at' => 'datetime',
            'is_sponsored' => 'boolean',
            'view_count' => 'integer',
        ];
    }

    /**
     * Get the reading time in minutes.
     */
    protected function readingTime(): Attribute
    {
        return Attribute::make(
            get: function () {
                $wordsPerMinute = 200;
                $words = str_word_count(strip_tags($this->content));

                return ceil($words / $wordsPerMinute);
            }
        );
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function postViews(): HasMany
    {
        return $this->hasMany(PostView::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', PostStatus::PUBLISHED)
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function scopeDraft($query)
    {
        return $query->where('status', PostStatus::DRAFT);
    }

    public function scopePendingReview($query)
    {
        return $query->where('status', PostStatus::PENDING_REVIEW);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', PostStatus::PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '>', now());
    }

    public function scopeTrending($query)
    {
        return $query->orderBy('view_count', 'desc')->latest('published_at');
    }
}
