<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OuterDonations extends Model
{
    use HasFactory;
    protected $table = 'outer_donations';
    protected $fillable = [
        'invoice_id',
        'amount',
        'duration',
        'donation_destination',
        'donators_id'
    ];
    public function donators()
    {
        return $this->belongsTo(Donators::class);
    }
}
