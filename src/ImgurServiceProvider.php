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
        $imgur = new Imgur([
            $this->app->config['client_id'], 
            $this->app->config['client_secret'],
        ]);

        $this->app->instance(Imgur::class, $imgur);
    }
}
