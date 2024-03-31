<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalSafe extends Model
{
    use HasFactory;
    protected $table = 'total_safes';
    protected $fillable = ['amount'];
}
