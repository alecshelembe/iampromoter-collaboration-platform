<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReloadLaravel extends Command
{
    
    protected $signature = 'app:reload';
    protected $description = 'Clear all caches and restart the application';

    public function handle()
    {
        $this->call('cache:clear');
        $this->call('route:clear');
        $this->call('config:clear');
        $this->call('view:clear');
        $this->call('config:cache');
        $this->info('All caches cleared and config cached successfully.');
    }
}
