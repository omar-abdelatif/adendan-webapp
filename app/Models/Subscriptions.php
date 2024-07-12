<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;
    protected $table = 'subscriptions';
    protected $fillable = [
        'member_id',
        'subscription_cost',
        'invoice_no',
        'period',
        'delays',
        'payment_type',
        'delays_period',
        'subscribers_id',
        'pay_date'
    ];
    public function subscribers()
    {
        return $this->belongsTo(Subscribers::class);
    }
}
