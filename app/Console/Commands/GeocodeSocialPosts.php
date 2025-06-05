<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SocialPost;
use Illuminate\Support\Facades\Http;

class GeocodeSocialPosts extends Command
{
    protected $signature = 'socialposts:geocode';
    protected $description = 'Geocode addresses in social_posts where lat/lng is missing';
    // test directly in browser https://maps.googleapis.com/maps/api/geocode/json?address=29+Miriam+Makeba+St+Johannesburg+2001&key=AIzaSyCAeg9kyCLifXnx6kQVA0vwyeZAdK76E3A
    public function handle()
    {
        $apiKey = config('services.google_maps.api_key_commands');

        $posts = SocialPost::whereNull('lat')
            ->orWhereNull('lng')
            ->get();

        $this->info("Found {$posts->count()} posts to geocode.");

        foreach ($posts as $post) {
            $this->line("Geocoding: {$post->address}");

            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $post->address,
                'key' => $apiKey, 
            ]);
            

            if ($response->successful() && $response['status'] === 'OK') {
                $location = $response['results'][0]['geometry']['location'];
                $post->lat = $location['lat'];
                $post->lng = $location['lng'];
                $post->save();

                $this->info("Saved: {$post->lat}, {$post->lng}");
            } else {
                $this->error("Failed to geocode: {$post->address}");
            }
        }

        $this->info("Geocoding complete!");
    }
}
