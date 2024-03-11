<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribers extends Model
{
    use HasFactory;
    protected $table = 'subscribers';
    protected $fillable = [
        'member_id',
        'name',
        'nickname',
        'ssn',
        'address',
        'educational_qualification',
        'qualification_date',
        'job',
        'job_destination',
        'job_tel',
        'job_address',
        'home_tel',
        'martial_status',
        'birthdate',
        'mobile_no',
        'membership_type',
        'id_img',
        'status',
        'img',
    ];
    public function subscriptions(){
        return $this->hasMany(Subscriptions::class);
    }
    public function delays(){
        return $this->hasOne(Delay::class);
    }
    public function donations()
    {
        return $this->hasMany(Donations::class);
    }
}
