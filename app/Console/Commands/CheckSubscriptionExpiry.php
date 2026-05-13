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
    public function handle(): void {
        SMSSubscribers::where('status', 'active')->where('expiry_date', '<', Carbon::today())->update(['status' => 'inactive']);
    }
}
