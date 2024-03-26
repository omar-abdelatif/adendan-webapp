<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Olddelays extends Model
{
    use HasFactory;
    protected $table = 'olddelays';
    protected $fillable = [
        'delay_period',
        'member_id',
        'amount',
    ];
    public function subscribers()
    {
        return $this->belongsTo(Subscribers::class);
    }
}
