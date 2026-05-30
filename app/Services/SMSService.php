<?php

namespace App\Services;

// use App\Models\SMSMSGS;
use App\Models\SMSSubscribers;

class SMSService {
    public function updateSmsFees($fees, int $amount) {
        return $fees->update([
            'amount' => $amount,
        ]);
    }
    // private function storeSms (string $content, string $status) :void {
    //     SMSMSGS::create([
    //         'sent_status' => $status,
    //         'message' => $content,
    //     ]);
    // }
    public function getSmsStatus(int $memberId) {
        $subscriber = SMSSubscribers::where('member_id', $memberId)->first();
        if (!$subscriber) {
            return false;
        }
        return [
            'status' => $subscriber->active_sms,
            'subscription_date' => $subscriber->subscription_start_date,
            'expiry_date' => $subscriber->subscription_expiry_date,
        ];
    }
    public function deleteSubscriber(int $id) {
        return SMSSubscribers::findOrFail($id)->delete();
    }
}
