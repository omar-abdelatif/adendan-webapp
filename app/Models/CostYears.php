<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostYears extends Model
{
    use HasFactory;
    protected  $table = 'cost_years';
    protected $fillable = [
        'cost',
        'year'
    ];
}
