<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FCM
{
    protected static $firebaseUrl = "https://fcm.googleapis.com/fcm/send";
    protected static $firebaseKey;
    protected static $regids = [];

    public function __construct()
    {
        self::$firebaseKey = config('app.fcm_key');
    }

    public static function to($regids = [])
    {
        self::$regids = $regids;
        return new static();
    }

    public static function send($data)
    {
        try {
            Log::info('Sending FCM notification', ['data' => $data]);

            if (count(self::$regids)) {
                $regids = array_values(array_unique(self::$regids));
                $postData = [
                    'registration_ids' => $regids,
                    'data' => $data,
                    'content_available' => true,
                    'priority' => 'high',
                ];

                $response = Http::withHeaders([
                    'Authorization' => "key=" . self::$firebaseKey
                ])->post(self::$firebaseUrl, $postData);

                Log::info('FCM notification sent', ['response' => $response->json()]);
                return $response->json();
            }
        } catch (\Throwable $th) {
            Log::error('FCM send error: ' . $th->getMessage(), ['data' => $data]);
            throw $th;
        }
    }
}
