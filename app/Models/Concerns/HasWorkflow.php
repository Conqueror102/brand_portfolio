<?php

namespace App\Models\Concerns;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/** Follow-up notes and an assigned team member for enquiries and applications. */
trait HasWorkflow
{
    /** @return MorphMany<Note, $this> */
    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable')->latest()->latest('id');
    }

    /** @return BelongsTo<User, $this> */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function log(string $body, bool $system = true): void
    {
        $this->notes()->create(['user_id' => auth()->id(), 'body' => $body, 'is_system' => $system]);
    }
}
