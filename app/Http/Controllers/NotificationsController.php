<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Subscribers;
use Google\Client as GoogleClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationsController extends Controller {
    private function getAccessToken(): string {
        return cache()->remember('firebase_access_token', now()->addMinutes(50), function () {
            $credentials = json_decode(file_get_contents(config('services.firebase.credentials')), true);
            $client = new GoogleClient();
            $client->setAuthConfig($credentials);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->refreshTokenWithAssertion();
            return $client->getAccessToken()['access_token'];
        });
    }
    private function sendToOne(string $fcmToken, string $title, string $body, array $data = []): bool {
        $projectId   = config('services.firebase.project_id');
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
                    'notification' => [
                        'notification_priority' => 'PRIORITY_HIGH',
                        'default_sound'         => true,
                        'default_vibrate_timings' => true,
                    ],
                ],
                'data' => $data,
            ]
        ]);
        if ($response->status() === 404) {
            $errorCode = $response->json()['error']['details'][0]['errorCode'] ?? '';
            if ($errorCode === 'UNREGISTERED') {
                Subscribers::where('fcm_token', $fcmToken)->update(['fcm_token' => null]);
            }
        }
        Log::info('FCM Response', [
            'project_id' => $projectId,
            'token'      => substr($fcmToken, 0, 20) . '...',
            'status'     => $response->status(),
            'body'       => $response->json(),
        ]);
        return isset($response->json()['name']);
    }
    public function sendNewsNotification(News $news) {
        $tokens = Subscribers::whereNotNull('fcm_token')->pluck('fcm_token');
        foreach ($tokens as $token) {
            $this->sendToOne(
                fcmToken: $token,
                title: 'خبر جديد',
                body: $news->title,
                data: [
                    'type'    => 'news',
                    'news_id' => (string) $news->id,
                ]
            );
        }
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
