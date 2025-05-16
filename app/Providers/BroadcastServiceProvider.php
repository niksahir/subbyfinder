<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register the broadcasting routes
        Broadcast::routes();

        // Load custom channel definitions
        require base_path('routes/channels.php');
    }

    public function register()
    {
        //
    }
}
