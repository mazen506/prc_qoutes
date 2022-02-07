<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        View::share('storage_url', 'https://mazmustaws.s3.us-east-2.amazonaws.com');
        //remove index.php from url
        // if (Str::endsWith(Arr::get($_SERVER, 'REQUEST_URI', ''), 'index.php')) {
        //     abort(404);
        //  }
        //error_reporting(E_ALL ^ E_NOTICE);
    }
}
