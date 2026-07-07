<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SpatieActivityLog extends SpatieActivity {
    protected function customCauser(): Attribute {
        return Attribute::make( get: fn() => $this->causer?->name );
    }
}
