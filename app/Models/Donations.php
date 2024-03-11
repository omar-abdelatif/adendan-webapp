<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donations extends Model
{
    use HasFactory;
    protected $table = 'donations';
    protected $fillable = [
        'member_id',
        'amount',
        'invoice_no',
        'donation_duration',
        'donation_type',
        'other_donation',
        'donation_destination',
        'subscribers_id',
    ];
    public function subscribers()
    {
        return  $this->belongsTo(Subscribers::class);
    }
}
