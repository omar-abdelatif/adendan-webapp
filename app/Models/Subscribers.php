<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Subscribers extends Authenticatable {
    use HasFactory, LogsActivity, HasApiTokens;
    protected $table = 'subscribers';
    protected $hidden = ['password'];
    protected $fillable = [
        'member_id',
        'name',
        'slug',
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
        'another_mobile_no',
        'membership_type',
        'id_img',
        'status',
        'img',
        'tomb_name',
    ];
    public function dues(){
        return $this->hasMany(Due::class, 'member_id', 'member_id');
    }
    public function paymentTransactions(){
        return $this->hasMany(PaymentTransaction::class, 'member_id', 'member_id');
    }
    public function donations(){
        return $this->hasMany(Donations::class);
    }
    public function tomb(){
        return $this->belongsTo(Tombs::class, 'tomb_name', 'title');
    }
    protected function getDynamicLogName(): string{
        return 'Subscribers';
    }
    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logAll()->useLogName($this->getDynamicLogName())->logOnlyDirty()->setDescriptionForEvent(function (string $eventName) {
            return $this->getTranslatedDescription($eventName);
        });
    }
    protected function getTranslatedDescription(string $eventName): string {
        $descriptions = [
            'created' => 'تم إضافة العضو ":name".',
            'updated' => 'تم تحديث العضو ":name".',
            'deleted' => 'تم حذف العضو ":name".',
        ];
        $arDescription = $descriptions[$eventName] ?? 'حدث غير معروف للعضو';
        return strtr($arDescription, [':name' => $this->name ?? 'اسم غير معروف']);
    }
    public function getAuthIdentifierName() {
        return 'ssn';
    }
}
