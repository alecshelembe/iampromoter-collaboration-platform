<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MobileAppBooking;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NotifyLatestBookings extends Command
{
    protected $signature = 'bookings:notify-latest 
        {expo_token? : The Expo push token to send notification to}';

    protected $description = 'Notify via Expo about latest bookings in the last 30 minutes';

    public function handle()
    {
        // Get from argument or .env via config
        // $expoToken = 'ExponentPushToken[fbx4IWKRdjxiVsX6pLjilK]';
        $expoToken = config('services.expo_push_token');

        // Sanity check
        if (!$expoToken) {
            $this->error('Expo token not found.');
            return 1;
        }

        $since = Carbon::now()->subMinutes(15); // or 1 minute if testing
        $bookings = MobileAppBooking::where('created_at', '>=', $since)->get();

        if ($bookings->isEmpty()) {
            $this->info('No new bookings');
            return 0;
        }

        $count = $bookings->count();
        $latestBooking = $bookings->last();

        $title = '📅 New Booking Alert!';
        $body = "{$count} new booking(s). Latest from {$latestBooking->name} at " . $latestBooking->datetime->format('g:i A');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://exp.host/--/api/v2/push/send', [
            'to' => $expoToken,
            'title' => $title,
            'body' => $body,
        ]);

        Log::info('Expo Booking Notification Sent', [
            'to' => $expoToken,
            'title' => $title,
            'body' => $body,
            'response_status' => $response->status(),
            'response_body' => $response->json(),
        ]);

        $this->info("Sent notification: {$body}");
        return 0;
    }
}
