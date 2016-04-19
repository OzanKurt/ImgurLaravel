<?php

namespace Kurt\Imgur;

use Imgur\Client;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Imgur {

    private $client;

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
     * Upload a file from the request.
     * 
     * @param  UploadedFile $uploadedFile
     * @param  array        $data
     * 
     * @return \Imgur\Api\Model\Image
     */
    public function upload(UploadedFile $uploadedFile, array $data = [])
    {
        $imageApi = $this->client->api('image');

        $imageMagager = app(ImageManager::class);

        $image = $imageMagager->make($uploadedFile);

        $extension = $uploadedFile->getClientOriginalExtension();

        $imageEncoded = $image->encode($extension)->getEncoded();

        $response = $imageApi->upload([
            'image' => $imageEncoded,
            'type' => $extension,
        ] + $data);

        return $this->handleUploadResponse($response);
    }

    /**
     * Upload a file from a given URL.
     * 
     * @param  string $url
     * @param  array  $data
     * 
     * @return \Imgur\Api\Model\Image
     */
    public function uploadFromUrl($url, array $data = [])
    {
        $imageApi = $this->client->api('image');

        $response = $imageApi->upload([
            'image' => $url,
            'type' => 'url',
        ] + $data);

        return $this->handleUploadResponse($response);
    }

    /**
     * Handles the response from upload.
     * 
     * @param  array $response
     * 
     * @return \Imgur\Api\Model\Image
     */
    private function handleUploadResponse($response)
    {
        if (!$response->getSuccess()) {
            throw new \Exception("Upload failed");
        }

        $imageModel = new \Imgur\Api\Model\Image($response->getData());
        
        return $imageModel;
    }

    /**
     * Forward some calls to the image api itself.
     * 
     * @param  string $method
     * @param  array  $args
     */
    public function __call($method, $args)
    {
        $imageApi = $this->client->api('image');

        if (in_array($method, ['image'])) {
            return call_user_func_array([$imageApi, $method], $args);
        }
    }
}
