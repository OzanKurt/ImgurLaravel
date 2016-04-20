<?php 

namespace Kurt\Imgur;

use Imgur\Api\Model\Image;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Kurt\Imgur\Exceptions\UploadFailedException;

/**
 * Contains the functional to ease the usage of `\Imgur\Api\Image`.
 *
 * @author Ozan Kurt <ozankurt2@gmail.com>
 * @package ozankurt/imgur-laravel
 * @version 1.0.1
 */
trait ImageApiHelperTrait {

    /**
     * Upload an image by using the file from request.
     * 
     * @param  \Illuminate\Http\UploadedFile    $uploadedFile   The uploaded file.
     * @param  array                            $data           Extra data you might want to send imgur.
     * 
     * @return \Imgur\Api\Model\Image
     */
    public function upload(UploadedFile $uploadedFile, array $data = [])
    {
        $image = app(ImageManager::class)->make($uploadedFile);

        $extension = $uploadedFile->extension();

        $imageEncoded = $image->encode($extension)->getEncoded();

        $response = $this->getImageApi()->upload([
            'image' => $imageEncoded,
            'type' => $extension,
        ] + $data);

        return $this->handleUploadResponse($response);
    }

    /**
     * Upload an image by using the given URL.
     * 
     * @param  string $url      The image url.
     * @param  array  $data     Extra data you might want to send imgur.
     * 
     * @return \Imgur\Api\Model\Image
     */
    public function uploadFromUrl($url, array $data = [])
    {
        $response = $this->getImageApi()->upload([
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
     *
     * @throws \Kurt\Imgur\Exceptions\UploadFailedException Throws an exception if the upload fails.
     */
    private function handleUploadResponse($response)
    {
        if (!$response->getSuccess()) {
            throw new UploadFailedException;
        }

        $imageModel = new Image($response->getData());
        
        return $imageModel;
    }
}