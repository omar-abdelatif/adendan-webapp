<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchedData extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'mobile_number',
        'ssn',
        'address',
        'birthdate',
        'member_id'
    ];
}