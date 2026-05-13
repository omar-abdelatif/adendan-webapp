<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMSSubscribers extends Model {
    protected $table = 'sms_subscribers';
    protected $fillable = [
        'member_id',
        'mobile_no',
        'amount',
        'subscription_expiry_date',
        'active_sms',
    ];
    public function subscriber(){
        return $this->belongTo(Subscribers::class, 'member_id', 'member_id');
    }
}
