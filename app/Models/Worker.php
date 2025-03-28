<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;
    protected $table = 'workers';
    protected $fillable = [
        'name',
        'phone_number',
        'craft',
        'other_craft',
        'location'
    ];
}
