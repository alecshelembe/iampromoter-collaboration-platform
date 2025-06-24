<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\UserLocation;

class SendBulkNotifications extends Command
{
    protected $signature = 'notifications:send-bulk 
                            {--title=🛍️ New location added!} 
                            {--body= Zure Wholesale has clothes for you!}';

    protected $description = 'Send a bulk Expo push notification to all users with registered Expo tokens';
    // php artisan notifications:send-bulk --title="🚨 Flash Sale!" --body="Send me a text custom prices"


    public function handle()
    {
        // Pull unique, non-null Expo tokens from users
        $expoTokens = UserLocation::whereNotNull('expo_push_token')->pluck('expo_push_token')->unique();
        // $expoTokens = "ExponentPushToken[ZSREVIM6C7ZLhJIbgosJXJ]";

        if ($expoTokens->isEmpty()) {
            $this->info('No Expo tokens found to send notifications.');
            return 0;
        }

        $title = $this->option('title');
        $body = $this->option('body');

        foreach ($expoTokens as $expoToken) {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://exp.host/--/api/v2/push/send', [
                'to' => $expoToken,
                'title' => $title,
                'body' => $body,
            ]);

            Log::info('Bulk Notification Sent', [
                'to' => $expoToken,
                'title' => $title,
                'body' => $body,
                'response_status' => $response->status(),
                'response_body' => $response->json(),
            ]);
        }

        $this->info("Notification sent to " . $expoTokens->count() . " user(s).");
        return 0;
    }
}
