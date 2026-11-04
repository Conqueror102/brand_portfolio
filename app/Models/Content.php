<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Editable page copy. Field definitions and defaults live in config/content.php.
 *
 * @property string $key
 * @property string|null $value
 * @property string|null $draft
 * @property bool $has_draft
 */
#[Fillable(['key', 'value', 'draft', 'has_draft'])]
class Content extends Model
{
    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $keyType = 'string';

    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['has_draft' => 'boolean'];
    }

    /** @return array<string, array{value: ?string, draft: ?string, has_draft: bool}> */
    public static function all_values(): array
    {
        return Cache::rememberForever('contents', fn () => static::all()
            ->mapWithKeys(fn (Content $c) => [$c->key => ['value' => $c->value, 'draft' => $c->draft, 'has_draft' => $c->has_draft]])
            ->all());
    }

    /** The field definition for a "group.field" key (keys contain a dot, so config() dot lookup cannot be used). @return array<string, mixed>|null */
    public static function field(string $key): ?array
    {
        return config('content.fields')[$key] ?? null;
    }

    public static function previewing(): bool
    {
        return request()->boolean('preview') && auth()->check();
    }

    public static function read(string $key): mixed
    {
        $stored = static::all_values()[$key] ?? null;
        $default = static::field($key)['default'] ?? null;

        if ($stored && $stored['has_draft'] && static::previewing()) {
            return $stored['draft'] ?? $default;
        }

        return $stored && $stored['value'] !== null ? $stored['value'] : $default;
    }

    /** @param array<string, mixed> $values */
    public static function saveDraft(array $values): void
    {
        foreach ($values as $key => $value) {
            $row = static::firstOrNew(['key' => $key]);
            $current = $row->exists ? $row->value : null;
            $row->draft = $value;
            $row->has_draft = (string) $value !== (string) ($current ?? static::field($key)['default'] ?? '');
            $row->save();
        }
        Cache::forget('contents');
    }

    /** @param list<string> $keys */
    public static function publish(array $keys): void
    {
        foreach (static::whereIn('key', $keys)->where('has_draft', true)->get() as $row) {
            $row->update(['value' => $row->draft, 'draft' => null, 'has_draft' => false]);
        }
        Cache::forget('contents');
    }

    /** @param list<string> $keys */
    public static function discard(array $keys): void
    {
        static::whereIn('key', $keys)->update(['draft' => null, 'has_draft' => false]);
        Cache::forget('contents');
    }
}
