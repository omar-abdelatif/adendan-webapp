<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model {
    protected $fillable = [
        'item',
        'amount',
        'inv_no',
        'member_id',
        'payment_cat',
        'payment_date',
        'payment_method',
        'transaction_cat',
        'transaction_type',
    ];
    public function subscriber() {
        return $this->belongsTo(Subscribers::class, 'member_id', 'member_id');
    }
}
