<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class Bank extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'banks';
    protected $fillable = [
        'amount',
        'proof_img',
        'transaction_type',
        'transaction_date',
    ];
    protected function getDynamicLogName(): string {
        return 'Bank Reports';
    }
    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logAll()->useLogName($this->getDynamicLogName())->logOnlyDirty()->setDescriptionForEvent(function (string $eventName) {
            return $this->getTranslatedDescription($eventName);
        });
    }
    protected function getTranslatedDescription(string $eventName): string {
        $descriptions = [
            'updated' => 'تم تعديل مبلغ البنك إلى ":safe_amount".',
            'cashin' => 'تم إيداع مبلغ الى البنك',
            'cashout' => 'تم سحب مبلغ من البنك',
        ];
        if($this->transaction_type === 'بنك/سحب'){
            $eventName = 'cashout';
        } else {
            $eventName = 'cashin';
        }
        $amount = $descriptions[$eventName] ?? 'حدث غير معروف للخزينة';
        return str_replace(':safe_amount', $this->amount, $amount);
    }
}
