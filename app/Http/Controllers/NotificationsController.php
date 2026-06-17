<?php

namespace App\Http\Controllers;

use App\Models\Subscribers;
use App\Services\NotificationSerivce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Google\Client as GoogleClient;

class NotificationsController extends Controller {
    public function __construct(protected NotificationSerivce $notificationSerivce) {}
    private function getAccessToken(): string {
        return cache()->remember('firebase_access_token', now()->addMinutes(50), function () {
            $credentials = json_decode( file_get_contents(env('FIREBASE_CREDENTIALS')), true );
            $client = new GoogleClient();
            $client->setAuthConfig($credentials);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->refreshTokenWithAssertion();
            return $client->getAccessToken()['access_token'];
        });
    }
    private function sendToOne(string $fcmToken, string $title, string $body): bool {
        $projectId   = env('FIREBASE_PROJECT_ID');
        $accessToken = $this->getAccessToken();
        $url         = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
        $response = Http::withToken($accessToken)->post($url, [
            'message' => [
                'token'        => $fcmToken,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
                'android' => [
                    'priority' => 'high',
                ],
            ]
        ]);
        return isset($response->json()['name']);
    }
    public function sendToSubscribers(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'body'  => 'required|string',
        ]);
        $tokens = Subscribers::whereNotNull('fcm_token')->pluck('fcm_token', 'id');
        if ($tokens->isEmpty()) {
            return response()->json(['message' => 'لا يوجد مشتركون'], 200);
        }
        $success = 0;
        $failed  = 0;
        foreach ($tokens as $userId => $token) {
            $sent = $this->sendToOne($token, $request->title, $request->body);
            $sent ? $success++ : $failed++;
        }
        return response()->json([
            'message' => 'تم الإرسال',
            'success' => $success,
            'failed'  => $failed,
        ]);
    }
    public function updateFcmToken(Request $request) {
        $request->validate(['fcm_token' => 'required|string']);
        $id = $request->user()->id;
        $subscriber = Subscribers::where('id', $id)->first();
        if (!$subscriber) {
            return response()->json(['message' => 'المشترك غير موجود'], 404);
        }
        $subscriber->update(['fcm_token' => $request->fcm_token]);
        return response()->json(['message' => 'تم الحفظ']);
    }
}
