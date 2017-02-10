<?php

namespace Kurt\Imgur;

use Illuminate\Support\ServiceProvider;

use Kurt\Imgur\Exceptions\InvalidAuthCredentialsException;

/**
 * Service provider for Laravel integration.
 *
 * @author Ozan Kurt <ozankurt2@gmail.com>
 * @package ozankurt/imgur-laravel
 * @version 5.4.0
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
        $client_id = $this->app->config->get('services.imgur.client_id');
        $client_secret = $this->app->config->get('services.imgur.client_secret');
        
        if (is_null($client_id) || is_null($client_secret)) {
            throw new InvalidAuthCredentialsException;
        }

        $kurtImgur = new Imgur($client_id, $client_secret);

        $this->app->instance(Imgur::class, $kurtImgur);

        $this->app->instance('kurt.imgur', $kurtImgur);
    }
}
