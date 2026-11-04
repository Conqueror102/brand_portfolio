<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * A repeatable piece of content. Types and their fields are defined in config/collections.php.
 *
 * @property int $id
 * @property string $type
 * @property string $title
 * @property string|null $slug
 * @property string|null $subtitle
 * @property string|null $body
 * @property string|null $icon
 * @property string|null $image
 * @property string|null $file
 * @property string|null $url
 * @property CarbonImmutable|null $date
 * @property string|null $category
 * @property int $sort_order
 * @property bool $is_published
 */
#[Fillable(['type', 'title', 'slug', 'subtitle', 'body', 'icon', 'image', 'file', 'url', 'date', 'category', 'sort_order', 'is_published'])]
class Item extends Model
{
    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['date' => 'date', 'is_published' => 'boolean', 'sort_order' => 'integer'];
    }

    protected static function booted(): void
    {
        static::saved(fn () => self::$listCache = []);
        static::deleted(fn () => self::$listCache = []);
        static::saving(function (Item $item) {
            if (config('collections.'.$item->type.'.pages')) {
                $base = Str::slug($item->title) ?: 'item';
                $slug = $base;
                $i = 2;
                while (static::where('type', $item->type)->where('slug', $slug)->whereKeyNot($item->id)->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $item->slug = $slug;
            }
        });
    }

    /** @param Builder<Item> $query */
    public function scopeOfType(Builder $query, string $type): void
    {
        $query->where('type', $type)->orderBy('sort_order')->orderBy('id');
    }

    /** Published items of a type, in their admin order. @return Collection<int, Item> */
    /** @var array<string, Collection<int, Item>> */
    private static array $listCache = [];

    public static function list(string $type): Collection
    {
        return self::$listCache[$type] ??= static::ofType($type)->where('is_published', true)->get();
    }

    public function imageUrl(): ?string
    {
        return $this->image ? media_url($this->image) : null;
    }

    public function fileUrl(): ?string
    {
        return $this->file ? media_url($this->file) : null;
    }

    public function imageAlt(): string
    {
        return $this->image ? (string) Media::where('path', $this->image)->value('alt') : '';
    }

    /** Only embed players from known hosts. */
    public function embedUrl(): ?string
    {
        if (! $this->url) {
            return null;
        }
        $url = $this->url;
        if (preg_match('~(?:youtube\.com/watch\?v=|youtu\.be/)([\w-]{6,})~', $url, $m)) {
            return 'https://www.youtube-nocookie.com/embed/'.$m[1];
        }
        if (preg_match('~vimeo\.com/(\d+)~', $url, $m)) {
            return 'https://player.vimeo.com/video/'.$m[1];
        }
        if (preg_match('~open\.spotify\.com/(episode|show)/([\w]+)~', $url, $m)) {
            return 'https://open.spotify.com/embed/'.$m[1].'/'.$m[2];
        }

        return null;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
