<?php

namespace Kurt\Imgur;

use Imgur\Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Imgur {

    private $client;

    function __construct($client_id, $client_secret = null)
    {
        if (is_null($client_secret)) {
            list($client_id, $client_secret) = $client_id;
        }

        $this->client = new Client();

        $this->client->setOption('client_id', $client_id);
        $this->client->setOption('client_secret', $client_secret);
    }

    public function getClient()
    {
        return $this->client;
    }

    public function upload(UploadedFile $uploadedFile, array $data)
    {
        $imageApi = $this->client->api('image');

        $image = $uploadedFile;

        $imageApi->upload(['image' => $image] + $data);
    }
}
