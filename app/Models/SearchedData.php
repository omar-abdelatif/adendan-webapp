<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchedData extends Model
{
    use HasFactory;
    protected $table = 'searched_data';
    protected $fillable = ['searched_data'];
}
