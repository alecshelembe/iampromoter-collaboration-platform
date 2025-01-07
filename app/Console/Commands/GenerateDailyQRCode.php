<?php

namespace App\Console\Commands;
// app/Console/Commands/GenerateDailyQRCode.php

use Illuminate\Console\Command;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateDailyQRCode extends Command
{
    protected $signature = 'qrcode:generate-daily';
    protected $description = 'Generate and store a new QR code daily';

    public function handle()
    {
        // Generate a unique QR code value
        $code = bin2hex(random_bytes(16)); // Generate a 32-character random string

        // Create a QR code and save it to the database
        \DB::table('qrcodes')->insert([
            'code' => $code,
            // 'expires_at' => Carbon::now()->addMinutes(5), // Set expiration for 5 minutes
            'expires_at' => Carbon::now()->addDay(), // Set expiration for 24 hours
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->info('Daily QR code generated successfully.');
    }
}

