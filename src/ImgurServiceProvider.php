<?php

namespace Kurt\Imgur;

use Illuminate\Support\ServiceProvider;

/**
 * Service provider for Laravel 5 integration.
 *
 * @author Ozan Kurt <ozankurt2@gmail.com>
 * @package ozankurt/imgur-laravel
 * @version 1.0.1
 */
class ImgurServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $config = $this->app->config;

        $this->app->singleton(Imgur::class, function() use ($config) {
            return new Imgur([
                $config->get('services.imgur.client_id'), 
                $config->get('services.imgur.client_secret'),
            ]);
        });
    }
}
