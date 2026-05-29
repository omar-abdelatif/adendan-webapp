<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMSFEES extends Model {
    protected $table = 'sms_fees';
    protected $fillable = ['item', 'amount'];
}
