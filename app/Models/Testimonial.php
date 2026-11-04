<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $quote
 * @property string $name
 * @property string|null $role
 * @property string|null $organisation
 * @property string $context
 * @property string|null $portrait
 * @property bool $is_published
 * @property bool $is_featured
 * @property bool $is_sample
 * @property int $sort_order
 */
#[Fillable(['quote', 'name', 'role', 'organisation', 'context', 'portrait', 'is_published', 'is_featured', 'is_sample', 'sort_order'])]
class Testimonial extends Model
{
    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['is_published' => 'boolean', 'is_featured' => 'boolean', 'is_sample' => 'boolean', 'sort_order' => 'integer'];
    }

    /** @param Builder<Testimonial> $query */
    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true)->orderBy('sort_order')->orderByDesc('id');
    }

    public function portraitUrl(): ?string
    {
        return media_url($this->portrait);
    }

    public function attribution(): string
    {
        return collect([$this->role, $this->organisation])->filter()->implode(', ');
    }
}
