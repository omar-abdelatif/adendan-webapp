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
        'invoice_no',
        'donation_type',
        'other_donation',
        'amount',
        'donation_destination',
        'donation_category',
        'subscribers_id',
    ];
    public function subscribers()
    {
        return  $this->belongsTo(Subscribers::class);
    }
}
