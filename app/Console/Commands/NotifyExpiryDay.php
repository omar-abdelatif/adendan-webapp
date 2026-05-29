<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Reminders;
use App\Models\SMSSubscribers;
use Illuminate\Console\Command;
use App\Services\EgyptLinxSmsService;

class NotifyExpiryDay extends Command {
    protected $signature = 'sms:notify-expiry-today';
    protected $description = 'إرسال تذكير للمشتركين الذين ينتهي اشتراكهم اليوم';

    public function handle(EgyptLinxSmsService $egyptLinxSmsService) {
        $gracePeriod = 15;
        $expiredDate = Carbon::today()->subDays($gracePeriod);
        $subscribers = SMSSubscribers::where('active_sms', 1)->whereDate('subscription_expiry_date', $expiredDate)->get();
        if ($subscribers->isEmpty()) {
            $this->info('لا توجد اشتراكات تنتهي اليوم.');
            return Command::SUCCESS;
        }
        SMSSubscribers::whereIn('id', $subscribers->pluck('id'))->update(['active_sms' => false]);
        $message = "انتهى اشتراكك في خدمة الرسائل. لديك فترة سماح {$gracePeriod} يوماً للتجديد، بعدها سيتوقف الاشتراك تلقائياً.";
        $phones = $subscribers->pluck('mobile_no')->toArray();
        try {
            $egyptLinxSmsService->sendArabic($phones, $message);
        } catch (\Exception $e) {
            $this->error('فشل الإرسال: ' . $e->getMessage());
        }
        $reminders = $subscribers->map(fn($subscriber) => [
            'subscriber_id' => $subscriber->id,
            'mobile_no'     => $subscriber->mobile_no,
            'type'          => 'expiry_day',
            'message'       => $message,
            'sent_at'       => now(),
            'created_at'    => now(),
            'updated_at'    => now(),
        ])->toArray();
        Reminders::insert($reminders);
        return Command::SUCCESS;
    }
}
