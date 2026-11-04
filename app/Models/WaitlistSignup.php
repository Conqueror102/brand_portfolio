<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $format
 * @property bool $marketing_consent
 */
#[Fillable(['name', 'email', 'format', 'marketing_consent'])]
class WaitlistSignup extends Model
{
    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['marketing_consent' => 'boolean'];
    }
}
