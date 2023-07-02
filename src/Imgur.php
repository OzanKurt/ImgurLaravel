<?php

namespace Kurt\Imgur;

use Exception;
use Imgur\Client;
use Kurt\Imgur\Traits\ImageApiHelperTrait;
use Kurt\Imgur\Exceptions\NonexistentApiException;
use Imgur\Api\AbstractApi;

class Imgur 
{
    use ImageApiHelperTrait;

    /**
     * Client instance.
     * @var \Imgur\Client
     */
    private $client;

    /**
     * List of available api's for magic calls.
     */
    private array $availableApis = [
        'account',
        'album',
        'albumOrImage',
        'comment',
        'conversation',
        'customGallery',
        'gallery',
        'image',
        'memegen',
        'notification',
        'topic',
    ];

    function __construct(string $client_id, string $client_secret)
    {
        $this->client = new Client();

        $this->client->setOption('client_id', $client_id);
        $this->client->setOption('client_secret', $client_secret);
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @throws \Kurt\Imgur\Exceptions\NonexistentApiException
     */
    public function getApi($api): AbstractApi
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

        throw new Exception("Nonexistent method `{$method}` called.");
    }
}
