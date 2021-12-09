<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;


class TranslationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    protected $langPath; 

    public function register()
    {
        $this->langPath = resource_path('lang/' . App::getLocale());
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Cache::forget('translations');
        view()->composer("layouts.app", function () {
        $locale = App::getLocale();
        $this->langPath = resource_path('lang/'. $locale);
        Cache::rememberForever('translations', function () {
            return collect(File::allFiles($this->langPath))->flatMap( function ($file) {
                return [
                    ($translation = $file->getBasename('.php')) => trans($translation),
                ];
            })->toJson(JSON_UNESCAPED_UNICODE);
        });
      });
    }
}
