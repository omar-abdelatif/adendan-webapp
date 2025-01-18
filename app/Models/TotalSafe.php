<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class TotalSafe extends Model {
    use HasFactory, LogsActivity;
    protected $table = 'total_safes';
    protected $fillable = ['amount'];
    protected function getDynamicLogName(): string {
        return 'Safe';
    }
    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logAll()->useLogName($this->getDynamicLogName())->logOnlyDirty()->setDescriptionForEvent(function (string $eventName) {
            return $this->getTranslatedDescription($eventName);
        });
    }
    protected function getTranslatedDescription(string $eventName): string {
        $descriptions = [
            'updated' => 'تم تعديل مبلغ الخزينة إلى ":safe_amount".',
        ];
        $amount = $descriptions[$eventName] ?? 'حدث غير معروف للخزينة';
        return str_replace(':safe_amount', $this->amount, $amount);
    }
}
