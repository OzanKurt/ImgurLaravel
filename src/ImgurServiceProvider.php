<?php

namespace Kurt\Imgur;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Kurt\Imgur\Exceptions\InvalidAuthCredentialsException;

class ImgurServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton(Imgur::class, function (Application $app) {
            $client_id = $app->config->get('services.imgur.client_id');
            $client_secret = $app->config->get('services.imgur.client_secret');

            if (is_null($client_id) || is_null($client_secret)) {
                throw new InvalidAuthCredentialsException;
            }

            return new Imgur($client_id, $client_secret);
        });
    }
}
