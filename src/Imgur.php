<?php

namespace Kurt\Imgur;

use Imgur\Client;
use Kurt\Imgur\Exceptions\NonexistentApiException;

class Imgur {

    use ImageApiHelperTrait;

    /**
     * Client instance.
     * @var \Imgur\Client
     */
    private $client;

    /**
     * List of available api's for magic calls.
     * @var [type]
     */
    private $availableApis = ['account', 'image', 'album', 'comment', 'conversation', 'gallery', 'image', 'memegen', 'notification'];

    /**
     * Imgur constructor.
     * 
     * @param string $client_id
     * @param string $client_secret
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
     * @param  string $api
     * 
     * @return \Imgur\Api\AbstractApi
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
     * Forward some calls to the image api itself.
     * 
     * @param  string $method
     * @param  array  $args
     */
    public function __call($method, $args)
    {
        if (preg_match('/^get([A-Z][a-z]+)Api$/', $method, $result)) {
            return $this->getApi($result[1]);
        }

        throw new \Exception("Nonexistent method `{$method}` called.");
    }
}
