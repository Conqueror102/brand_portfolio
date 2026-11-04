<?php

namespace App\Models;

use App\Models\Concerns\HasWorkflow;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $cohort
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string $role
 * @property string $location
 * @property string $goals
 * @property string $outcomes
 * @property string $motivation
 * @property string|null $support
 * @property string $availability
 * @property string $in_person
 * @property string $commitment
 * @property bool $marketing_consent
 * @property Carbon $privacy_consented_at
 * @property string $status
 * @property string $payment_status
 * @property string|null $internal_notes
 * @property Carbon|null $created_at
 */
#[Fillable([
    'cohort', 'name', 'email', 'phone', 'role', 'location', 'goals', 'outcomes', 'motivation', 'support',
    'availability', 'in_person', 'commitment', 'marketing_consent', 'privacy_consented_at', 'status', 'payment_status', 'assigned_to', 'internal_notes',
])]
class MentorshipApplication extends Model
{
    use HasWorkflow;

    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['marketing_consent' => 'boolean', 'privacy_consented_at' => 'datetime'];
    }
}
