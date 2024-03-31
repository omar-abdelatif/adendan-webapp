<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delay extends Model
{
    use HasFactory;
    protected $table = 'delays';
    protected $fillable = [
        'member_id',
        'paied',
        'remaing',
        'year',
        'yearly_cost',
        'payment_type',
        'subscribers_id'
    ];
    public function  subscriber() {
        return $this->belongsTo(Subscribers::class);
    }
}
