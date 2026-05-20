<?php

namespace App\Console\Commands;

use App\Models\Subscribers;
use Illuminate\Console\Command;

class GeneratePasswords extends Command {
    protected $signature = 'users:generate-password';
    protected $description = 'Create Password for all subscribers who do not have one';
    public function handle() {
        $count = 0;
        $this->info('Start generating passwords...');
        $subscribers = Subscribers::whereNull('password')->whereNotNull('ssn')->whereNotNull('mobile_no')->get();
        foreach ($subscribers as $subscriber) {
            if (!$subscriber->ssn || !$subscriber->mobile_no) {
                continue;
            }
            $password = substr($subscriber->ssn, -4) . substr($subscriber->mobile_no, -4);
            $subscriber->password = bcrypt($password);
            $subscriber->save();
            $count++;
        }
        $this->info($count);
        return Command::SUCCESS;
    }
}
