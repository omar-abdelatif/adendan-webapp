<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\SMSSubscribers;
use Illuminate\Console\Command;

class CheckSubscriptionExpiry extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature   = 'subscriptions:check-expiry';
    protected $description = 'تحويل الاشتراكات المنتهية إلى غير نشطة';


    /**
     * The console command description.
     *
     * @var string
     */
    public function handle() {
        $gracePeriod = 15;
        SMSSubscribers::where('active_sms', 1)->whereRaw('DATE_ADD(subscription_expiry_date, INTERVAL ? DAY) < ?', [$gracePeriod, Carbon::today()->toDateString()])->update(['active_sms' => 0]);
        return Command::SUCCESS;
    }
}
