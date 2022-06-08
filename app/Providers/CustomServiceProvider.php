<?php

namespace App\Providers;

use App\Models\Events_Model;
use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $events=Events_Model::latest()->take(4)->get();

        view()->share('events', $events);
    }
}
