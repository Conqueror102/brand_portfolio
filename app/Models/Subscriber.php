<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $email
 * @property string|null $name
 * @property list<string>|null $interests
 * @property string $token
 */
#[Fillable(['email', 'name', 'interests', 'token', 'consented_at', 'unsubscribed_at'])]
class Subscriber extends Model
{
    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['interests' => 'array', 'consented_at' => 'datetime', 'unsubscribed_at' => 'datetime'];
    }

    protected static function booted(): void
    {
        static::creating(fn (Subscriber $s) => $s->token ??= Str::random(48));
    }

    /** @param Builder<Subscriber> $query */
    public function scopeActive(Builder $query): void
    {
        $query->whereNull('unsubscribed_at');
    }
}
