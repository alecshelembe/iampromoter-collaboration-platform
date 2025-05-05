<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendExpoNotification extends Command
{
    protected $signature = 'expo:send 
                            {expo_token : The Expo push token} 
                            {--title=Hello : Notification title} 
                            {--body=This is a test notification. : Notification body}';

    protected $description = 'Send an Expo push notification';

    public function handle()
    {
        $expoToken = $this->argument('expo_token');
        $title = $this->option('title');
        $body = $this->option('body');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://exp.host/--/api/v2/push/send', [
            'to' => $expoToken,
            'title' => $title,
            'body' => $body,
        ]);

        Log::info('Expo Push Notification Sent (via command)', [
            'to' => $expoToken,
            'title' => $title,
            'body' => $body,
            'response_status' => $response->status(),
            'response_body' => $response->json(),
        ]);

        $this->info("Notification sent. Status: " . $response->status());
    }
}
