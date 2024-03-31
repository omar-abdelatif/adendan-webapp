<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafeReports extends Model
{
    use HasFactory;
    protected $table = 'safe_reports';
    protected $fillable = [
        'member_id',
        'transaction_type',
        'amount',
        'proof_img'
    ];
}
