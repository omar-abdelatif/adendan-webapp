<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class Donators extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'donators';
    protected $fillable = [
        'name',
        'mobile_number',
        'donator_type',
        'duration'
    ];
    public function outerdonations()
    {
        return $this->hasMany(OuterDonations::class);
    }
    protected function getDynamicLogName(): string{
        return 'Donators';
    }
    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logAll()->useLogName($this->getDynamicLogName())->logOnlyDirty()->setDescriptionForEvent(function (string $eventName) {
            return $this->getTranslatedDescription($eventName);
        });
    }
    protected function getTranslatedDescription(string $eventName): string {
        $descriptions = [
            'created' => 'تم إضافة المتبرع جديد ":name".',
            'updated' => 'تم تحديث بيانات المتبرع ":name".',
            'deleted' => 'تم حذف بيانات المتبرع ":name".',
        ];
        $arDescription = $descriptions[$eventName] ?? 'حدث غير معروف للعضو';
        return strtr($arDescription, [':name' => $this->name ?? 'اسم غير معروف']);
    }
}
