<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class Subscribers extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'subscribers';
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
        'membership_type',
        'id_img',
        'status',
        'img',
    ];
    public function subscriptions(){
        return $this->hasMany(Subscriptions::class);
    }
    public function delays(){
        return $this->hasMany(Delay::class);
    }
    public function donations(){
        return $this->hasMany(Donations::class);
    }
    public function olddelays(){
        return $this->hasMany(Olddelays::class);
    }
    public function donationDelays(){
        return $this->hasMany(DonationDelay::class);
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
}
