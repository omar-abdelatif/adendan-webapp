<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wedding extends Model
{
    use HasFactory;
    protected $table = 'weddings';
    protected $fillable = [
        'day',
        'date',
        'groom_name',
        'pride_father_name',
        'address',
        'from_time',
        'to_time'
    ];
}
