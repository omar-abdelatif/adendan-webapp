<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Reminders;
use App\Models\SMSSubscribers;
use Illuminate\Console\Command;
use App\Services\EgyptLinxSmsService;

class NotifyExpiryMonth extends Command {
    protected $signature   = 'sms:notify-expiry-month';
    protected $description = 'إرسال تذكير SMS للأعضاء قبل انتهاء اشتراكهم بشهر';

    /**
     * Execute the console command.
     */
    public function handle(EgyptLinxSmsService $egyptLinxSmsService) {
        $targetDate = Carbon::today()->addMonth()->toDateString();
        $subscribers = SMSSubscribers::where('active_sms', 1)->whereDate('subscription_expiry_date', $targetDate)->get();
        if ($subscribers->isEmpty()) {
            $this->info('لا توجد اشتراكات تنتهي بعد شهر.');
            return Command::SUCCESS;
        }
        $message = "العضو الكريم برجاء العلم ان اشتراك الرسائل الخاص بكم ينتهي بعد شهر. برجاء التجديد  للاستمرار في الاستفادة من الخدمة.";
        $phones = $subscribers->pluck('mobile_no')->toArray();
        try {
            $egyptLinxSmsService->sendArabic($phones, $message);
        } catch (\Exception $e) {
            $this->error('فشل الإرسال: ' . $e->getMessage());
        }
        $reminders = $subscribers->map(fn($subscriber) => [
            'subscriber_id' => $subscriber->id,
            'mobile_no'     => $subscriber->mobile_no,
            'type'          => 'month_before',
            'message'       => $message,
            'sent_at'       => now(),
            'created_at'    => now(),
            'updated_at'    => now(),
        ])->toArray();
        Reminders::insert($reminders);
        return Command::SUCCESS;
    }
}
