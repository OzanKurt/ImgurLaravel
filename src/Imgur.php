<?php

namespace Kurt\Imgur;

use Imgur\Client;
use Kurt\Imgur\Exceptions\NonexistentApiException;

/**
 * Contains the functional to ease the usage of `\Imgur\Client`.
 *
 * @author Ozan Kurt <ozankurt2@gmail.com>
 * @package ozankurt/imgur-laravel
 * @version 1.0.0
 */
class Imgur {

    use ImageApiHelperTrait;

    /**
     * Client instance.
     * @var \Imgur\Client
     */
    private $client;

    /**
     * List of available api's for magic calls.
     * @var string[] Imgur api names.
     */
    private $availableApis = ['account', 'image', 'album', 'comment', 'conversation', 'gallery', 'image', 'memegen', 'notification'];

    /**
     * Imgur constructor.
     * 
     * @param string $client_id     Client id of the imgur application.
     * @param string $client_secret Client secret of the imgur application.
     */
    function __construct($client_id, $client_secret = null)
    {
        if (is_null($client_secret)) {
            list($client_id, $client_secret) = $client_id;
        }

        $this->client = new Client();

        $this->client->setOption('client_id', $client_id);
        $this->client->setOption('client_secret', $client_secret);
    }

    /**
     * Imgur client accessor.
     * 
     * @return \Imgur\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Access an api from the client.
     * 
     * @param  string $api Name of the requested api.
     * 
     * @return \Imgur\Api\AbstractApi
     *
     * @throws \Kurt\Imgur\Exceptions\NonexistentApiException Throws an exception if the requested api does not exist.
     */
    public function getApi($api)
    {
        $api = strtolower($api);

        if (in_array($api, $this->availableApis)) {
            return call_user_func_array([$this->client, 'api'], [$api]);
        }

        throw new NonexistentApiException($api);
    }

    /**
     * Magic calls to access any existent api fluently.
     *
     * Example: <br>
     *     `$this->getImageApi();`
     * 
     * @param  string $method   Called method name.
     * @param  array  $args     Arguments of the method.
     *
     * @throws \Exception Throws an exception if there is no method.
     */
    public function __call($method, $args)
    {
        if (preg_match('/^get([A-Z][a-z]+)Api$/', $method, $result)) {
            return $this->getApi($result[1]);
        }

        throw new \Exception("Nonexistent method `{$method}` called.");
    }
}
