<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class Subscriptions extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'subscriptions';
    protected $fillable = [
        'member_id',
        'subscription_cost',
        'invoice_no',
        'period',
        'delays',
        'payment_type',
        'subscribers_id',
    ];
    public function subscribers()
    {
        return $this->belongsTo(Subscribers::class);
    }
    protected function getDynamicLogName(): string
    {
        return 'Subscriptions';
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->useLogName($this->getDynamicLogName())->logOnlyDirty()->setDescriptionForEvent(function (string $eventName) {
            return $this->getTranslatedDescription($eventName);
        });
    }
    protected function getTranslatedDescription(string $eventName): string
    {
        $subPayment = [
            'created' => 'تم إضافة اشتراك جديد للعضو ":subscriber_name".',
            'created_partial' => 'تم دفع جزء من مبلغ الإشتراك للعضو ":subscriber_name".',
            'created_full' => 'تم دفع مبلغ الإشتراك بالكامل للعضو ":subscriber_name".',
            'partial_arrears' => 'تم دفع جزء من متأخرات الإشتراك المستحقة للعضو ":subscriber_name".',
            'college_arrears' => 'تم دفع كل متأخرات الإشتراك المستحقة للعضو ":subscriber_name".',
        ];

        if ($eventName === 'created') {
            if ($this->payment_type === 'إشتراك جزئي') {
                $eventName = 'created_partial';
            } elseif ($this->payment_type === 'إشتراك كلي') {
                $eventName = 'created_full';
            } elseif ($this->payment_type === 'متأخرات جزئي') {
                $eventName = 'partial_arrears';
            } elseif ($this->payment_type === 'متأخرات كلي') {
                $eventName = 'college_arrears';
            } else {
                $eventName = 'created';
            }
        }
        $payment = $subPayment[$eventName] ?? 'حدث غير معروف.';
        $subscriberName = $this->subscribers->name ?? 'غير معروف';
        return strtr($payment, [
            ':subscriber_name' => $subscriberName,
        ]);
    }
}
