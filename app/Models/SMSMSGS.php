<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMSMSGS extends Model {
    protected $table = 'sms_msgs';
    protected $fillable = [
        'sent_status',
        'message',
    ];
}
