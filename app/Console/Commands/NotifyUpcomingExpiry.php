<?php

namespace App\Console\Commands;

use App\Models\SMSSubscribers;
use App\Services\EgyptLinxSmsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifyUpcomingExpiry extends Command {
    protected $signature   = 'sms:notify-expiry-upcoming';
    protected $description = 'إرسال تذكير SMS للأعضاء قبل انتهاء اشتراكهم بشهر';

    public function handle(EgyptLinxSmsService $egyptLinxSmsService){
        $targetDate = Carbon::today()->addMonth()->toDateString();
        $subscribers = SMSSubscribers::where('active_sms', 1)->whereDate('subscription_expiry_date', $targetDate)->get();
        $phones = $subscribers->pluck('mobile_no')->toArray();
        if (empty($subscribers)) {
            $this->info('لا يوجد اشتراكات تنتهي قريباً.');
            return Command::SUCCESS;
        }
        $egyptLinxSmsService->sendArabic($phones,"اشتراكك في خدمة الرسائل سينتهي قريباً. يرجى التجديد.");
        $this->info("تم إرسال " . count($subscribers) . " رسالة تذكير.");
        return Command::SUCCESS;
    }
}
