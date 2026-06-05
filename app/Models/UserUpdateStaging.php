<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUpdateStaging extends Model {
    protected $fillable = [
        'name',
        'member_id',
        'address',
        'mobile_no',
        'ssn',
        'birth_date',
        'job_title',
    ];
}
