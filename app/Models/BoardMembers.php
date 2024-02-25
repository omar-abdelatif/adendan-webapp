<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardMembers extends Model
{
    use HasFactory;
    protected $table = 'border_members';
    protected $fillable = [
        'name',
        'phone_number',
        'position',
        'img'
    ];
}
