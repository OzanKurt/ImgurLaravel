<?php 

namespace Kurt\Imgur;

use Imgur\Api\Model\Image;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Kurt\Imgur\Exceptions\UploadFailedException;

trait ImageApiHelperTrait {

    /**
     * Upload a file from the request.
     * 
     * @param  \Illuminate\Http\UploadedFile    $uploadedFile
     * @param  array                            $data
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
     * Upload a file from a given URL.
     * 
     * @param  string $url
     * @param  array  $data
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