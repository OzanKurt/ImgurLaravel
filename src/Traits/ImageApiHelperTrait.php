<?php 

namespace Kurt\Imgur\Traits;

use Illuminate\Http\UploadedFile;

trait ImageApiHelperTrait
{
    public function upload(UploadedFile $uploadedFile, array $data = []): array
    {
        return $this->getImageApi()->upload([
            'image' => $uploadedFile->getPathname(),
            'type' => 'file',
        ] + $data);
    }

    public function uploadFromBase64(string $base64, array $data = []): array
    {
        return $this->getImageApi()->upload([
            'image' => $base64,
            'type' => 'base64',
        ] + $data);
    }

    public function uploadFromUrl(string $url, array $data = []): array
    {
        return $this->getImageApi()->upload([
            'image' => $url,
            'type' => 'url',
        ] + $data);
    }
}
