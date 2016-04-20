<?php 

namespace Kurt\Imgur;

trait ImageApiHelperTrait {

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
}