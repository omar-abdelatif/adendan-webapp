<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tombs extends Model
{
    use HasFactory;
    protected $table = 'tombs';
    protected $fillable = [
        'title',
        'region',
        'tomb_guard_name',
        'tomb_guard_number',
        'location'
    ];
}
