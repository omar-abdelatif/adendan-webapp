<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OuterDonations extends Model
{
    use HasFactory;
    protected $table = 'outer_donations';
    protected $fillable = [
        'name',
        'donator_type',
        'donation_type',
        'invoice_id',
        'amount',
        'donation_destination',
        'donators_id'
    ];
    public function donators()
    {
        return $this->belongsTo(Donators::class);
    }
}
