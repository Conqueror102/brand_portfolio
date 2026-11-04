<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $category
 * @property string $excerpt
 * @property string $body
 * @property string|null $references
 * @property string|null $cover_image
 * @property string|null $external_url
 * @property string $status
 * @property bool $is_featured
 * @property bool $is_sample
 * @property Carbon|null $published_at
 * @property string|null $seo_description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['title', 'slug', 'category', 'excerpt', 'body', 'references', 'cover_image', 'external_url', 'status', 'is_featured', 'is_sample', 'published_at', 'seo_description'])]
class Article extends Model
{
    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_sample' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Article $article) {
            $article->slug = static::uniqueSlug($article->slug ?: $article->title, $article->id);
            if ($article->status === 'published' && ! $article->published_at) {
                $article->published_at = now();
            }
        });
    }

    public static function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $base = Str::slug($source) ?: 'article';
        $slug = $base;
        $i = 2;
        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    /** @param Builder<Article> $query */
    public function scopePublished(Builder $query): void
    {
        $query->where('status', 'published')->where('published_at', '<=', now());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function readMinutes(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags($this->body)) / 220));
    }

    public function coverUrl(): ?string
    {
        return media_url($this->cover_image);
    }

    /** Paragraph-separated plain text rendered as escaped HTML paragraphs and "## " subheadings. */
    public function bodyHtml(): string
    {
        return collect(preg_split("/\R{2,}/", trim($this->body)))
            ->map(function (string $block) {
                $block = trim($block);
                if (str_starts_with($block, '## ')) {
                    return '<h2>'.e(substr($block, 3)).'</h2>';
                }
                if (str_starts_with($block, '> ')) {
                    return '<blockquote><p>'.e(substr($block, 2)).'</p></blockquote>';
                }

                return '<p>'.nl2br(e($block)).'</p>';
            })
            ->implode("\n");
    }
}
