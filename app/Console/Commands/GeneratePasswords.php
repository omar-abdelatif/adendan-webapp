<?php

namespace App\Console\Commands;

use App\Models\Subscribers;
use Illuminate\Console\Command;

class GeneratePasswords extends Command {
    protected $signature = 'users:generate-password';
    protected $description = 'Create Password for all subscribers who do not have one';
    public function handle() {
        $this->info('Start generating passwords...');
        Subscribers::whereNull('password')->whereNotNull('ssn')->whereNotNull('mobile_no')->chunk(100, function ($subscribers) {
            foreach ($subscribers as $subscriber) {
                if (!$subscriber->ssn || !$subscriber->mobile_no) {
                    continue;
                }
                $password = substr($subscriber->ssn, -4) . substr($subscriber->mobile_no, -4);
                $subscriber->password = bcrypt($password);
                $subscriber->save();
            }
        });
        $this->info('Passwords generated successfully.');
    }
}
