<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donators extends Model
{
    use HasFactory;
    protected $table = 'donators';
    protected $fillable = [
        'name',
        'mobile_number',
        'donator_type',
        'duration'
    ];
    public function outerdonations()
    {
        return $this->hasMany(OuterDonations::class);
    }
}
