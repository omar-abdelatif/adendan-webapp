<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class TotalBank extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'total_banks';
    protected  $fillable = ['amount'];
    protected function getDynamicLogName(): string {
        return 'Bank';
    }
    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logAll()->useLogName($this->getDynamicLogName())->logOnlyDirty()->setDescriptionForEvent(function (string $eventName) {
            return $this->getTranslatedDescription($eventName);
        });
    }
    protected function getTranslatedDescription(string $eventName): string {
        $descriptions = [
            'updated' => 'تم تعديل مبلغ البنك إلى "":bank_amount.',
        ];
        $amount = $descriptions[$eventName] ?? 'حدث غير معروف للخزينة';
        return str_replace(':bank_amount', $this->amount, $amount);
    }
}
