<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationDelay extends Model
{
    use HasFactory;
    protected $table = 'donation_delays';
    protected  $fillable = [
        'member_id',
        'donation_type',
        'payment_type',
        'delay_amount',
        'amount_paied',
        'amount_remaining',
    ];
}
