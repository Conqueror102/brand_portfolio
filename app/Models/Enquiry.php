<?php

namespace App\Models;

use App\Models\Concerns\HasWorkflow;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $organisation
 * @property string|null $proposed_date
 * @property string|null $location
 * @property string|null $audience
 * @property int|null $participants
 * @property string $message
 * @property string $status
 * @property int|null $assigned_to
 * @property CarbonImmutable|null $follow_up_on
 * @property CarbonImmutable|null $scheduled_for
 * @property string|null $internal_notes
 * @property Carbon|null $created_at
 */
#[Fillable(['type', 'name', 'email', 'phone', 'organisation', 'proposed_date', 'location', 'audience', 'participants', 'message', 'status', 'assigned_to', 'follow_up_on', 'scheduled_for', 'internal_notes'])]
class Enquiry extends Model
{
    use HasWorkflow;

    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['follow_up_on' => 'date', 'scheduled_for' => 'date'];
    }

    public function typeLabel(): string
    {
        return config('site.enquiry_types.'.$this->type, ucfirst($this->type));
    }
}
