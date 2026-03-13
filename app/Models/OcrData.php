<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcrData extends Model {
    protected $fillable = [
        'name',
        'address',
        'nid',
        'birth_date',
    ];
}