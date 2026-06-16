<?php

namespace App\Http\Controllers;

use App\Services\NotificationSerivce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Google\Client as GoogleClient;

class NotificationsController extends Controller {
    public function __construct(protected NotificationSerivce $notificationSerivce) {}
    public function sendNotify(Request $request){
        $fcm = '';
        $title = "اشعار جديد";
        $description = "تيست تيست تيست";
        $credentialsFilePath = Http::get(env('FIREBASE_CREDENTIALS'));
        $client = new GoogleClient();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();
        $access_token = $token['access_token'];
        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];
        $data = [
            "message" => [
                "token" => $fcm,
                "notification" => [
                    "title" => $title,
                    "body" => $description,
                ],
            ]
        ];
        $payload = json_encode($data);
        $result = $this->initateNotify($headers, $payload);
        $error = $result['err'];
        $response = $result['res'];
        if ($error) {
            return response()->json([
                'message' => 'Curl Error: ' . $error
            ], 500);
        } else {
            return response()->json([
                'message' => 'Notification has been sent',
                'response' => json_decode($response, true)
            ]);
        }
    }
    public function initateNotify($headers, $payload){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/project_id/messages:send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return [
            'res' => $response,
            'err' => $err
        ];
    }
}
