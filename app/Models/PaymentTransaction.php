<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model {
    protected $fillable = [
        'member_id',
        'item',
        'amount',
        'inv_no',
        'payment_cat',
        'payment_date',
        'payment_method',
        'transaction_type',
    ];
    public function subscriber() {
        return $this->belongsTo(Subscribers::class, 'member_id', 'member_id');
    }
}
