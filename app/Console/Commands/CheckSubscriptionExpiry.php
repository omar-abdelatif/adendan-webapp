<?php

namespace App\Console\Commands;

use App\Models\SMSSubscribers;
use Carbon\Carbon;
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
        SMSSubscribers::where('active_sms', 1)->whereDate('subscription_expiry_date', Carbon::today())->update(['active_sms' => 0]);
        return Command::SUCCESS;
    }
}
