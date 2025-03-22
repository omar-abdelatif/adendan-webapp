<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class OuterDonations extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'outer_donations';
    protected $fillable = [
        'name',
        'donator_type',
        'donation_type',
        'invoice_id',
        'amount',
        'donation_destination',
        'donators_id'
    ];
    public function donators()
    {
        return $this->belongsTo(Donators::class);
    }
    protected function getDynamicLogName(): string
    {
        return 'OuterDonations';
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
            'created' => 'تم دفع تبرع خارجي من المتبرع ":donators_name".',
        ];

        $payment = $subPayment[$eventName] ?? 'حدث غير معروف.';
        $donatorName = $this->donators->name ?? 'غير معروف';
        return strtr($payment, [
            ':donators_name' => $donatorName,
        ]);
    }
}
