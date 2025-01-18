<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class SafeReports extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'safe_reports';
    protected $fillable = [
        'member_id',
        'transaction_type',
        'amount',
        'proof_img',
        'invoice_no'
    ];
    protected function getDynamicLogName(): string {
        return 'Safe Reports';
    }
    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logAll()->useLogName($this->getDynamicLogName())->logOnlyDirty()->setDescriptionForEvent(function (string $eventName) {
            return $this->getTranslatedDescription($eventName);
        });
    }
    protected function getTranslatedDescription(string $eventName): string {
        $descriptions = [
            'updated' => 'تم تعديل مبلغ الخزينة إلى ":safe_amount".',
            'cashin' => 'تم إيداع مبلغ الى الخزينة',
            'cashout' => 'تم سحب مبلغ من الخزينة',
        ];
        if($this->transaction_type === 'خزنة/سحب'){
            $eventName = 'cashout';
        } else {
            $eventName = 'cashin';
        }
        $amount = $descriptions[$eventName] ?? 'حدث غير معروف للخزينة';
        return str_replace(':safe_amount', $this->amount, $amount);
    }
}
