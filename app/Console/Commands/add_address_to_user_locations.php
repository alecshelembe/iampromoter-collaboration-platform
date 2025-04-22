<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserLocation;
use Illuminate\Support\Facades\Http;

class add_address_to_user_locations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user_locations:reverse-geocode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill in missing addresses for social_posts using lat/lng';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = UserLocation::whereNull('address')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $this->info("Found {$posts->count()} posts missing addresses.");

        foreach ($posts as $post) {
            $this->line("Reverse geocoding: ({$post->latitude}, {$post->longitude})");

            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'latlng' => "{$post->latitude},{$post->longitude}",
                'key' => env('GOOGLE_MAPS_API_KEY'),
            ]);

            if ($response->successful() && $response['status'] === 'OK') {
                $address = $response['results'][0]['formatted_address'];
                $post->address = $address;
                $post->save();

                $this->info("Saved address: {$address}");
            } else {
                $this->error("Failed to reverse geocode coordinates.");
            }
        }

        $this->info("Reverse geocoding complete!");
    }
}
