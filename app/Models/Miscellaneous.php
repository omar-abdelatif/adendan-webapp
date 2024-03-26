<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miscellaneous extends Model
{
    use HasFactory;
    protected $table = 'miscellaneouses';
    protected $fillable = [
        'category',
        'amount',
        'invoice_img',
        'other_category'
    ];
}
