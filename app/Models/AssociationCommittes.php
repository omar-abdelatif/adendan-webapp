<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationCommittes extends Model
{
    use HasFactory;
    protected $table = 'association_committes';
    protected $fillable = [
        'name',
        'description',
        'boss',
        'tasks'
    ];
}
