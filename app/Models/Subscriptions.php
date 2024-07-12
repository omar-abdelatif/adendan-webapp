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
        'subscribers_id',
    ];
    public function subscribers()
    {
        return $this->belongsTo(Subscribers::class);
    }
}
