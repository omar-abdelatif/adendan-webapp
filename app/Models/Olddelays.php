<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Olddelays extends Model
{
    use HasFactory;
    protected $table = 'olddelays';
    protected $fillable = [
        'amount',
        'member_id',
        'old_delay_type',
        'delay_amount',
        'delay_remaining'
    ];
    public function subscribers()
    {
        return $this->belongsTo(Subscribers::class);
    }
}
