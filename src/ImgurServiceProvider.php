<?php

namespace Kurt\Imgur;

use Illuminate\Support\ServiceProvider;

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
                $config['client_id'], 
                $config['client_secret'],
            ]);
        });
    }
}
