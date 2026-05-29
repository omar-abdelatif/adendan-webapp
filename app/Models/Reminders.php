<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminders extends Model {
    protected $fillable = [
        'message',
        'type',
        'sent_at',
        'sms_subscribers_id',
    ];
}
