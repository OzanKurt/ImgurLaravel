# ImgurLaravel

A Laravel 5 package to simplify [Imgur Api Client](https://github.com/Adyg/php-imgur-api-client).
For detailed information about how to use the Imgur client itself please check the [documentation of Imgur Api Client](https://github.com/Adyg/php-imgur-api-client/tree/master/doc).

## Usage

Check the available methods from [ImgurLaravel-API](http://packages.ozankurt.com/imgur-laravel/1.0/).

### Image Api Example
```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Kurt\Imgur\Imgur;

class HomeController extends Controller
{
    /**
     * Imgur instance.
     *
     * @var \Kurt\Imgur\Imgur
     */
    private $imgur;

    public function __construct(Imgur $imgur)
    {
        $this->imgur = $imgur;
    }

    /**
     * Retrieve an image by its id.
     * 
     * @return \Imgur\Api\Model\Image
     */
    public function getImage(Request $request)
    {
        $imageApi = $this->imgur->getImageApi();

        $imageModel = $imageApi->image(
            $imageModel->input('id')
        );

        return $imageModel;
    }

    /**
     * Upload an image with a given url or a file.
     * 
     * @return \Imgur\Api\Model\Image
     */
    public function getUpload(Request $request)
    {
        // Upload with a url.
        $imageModel = $this->imgur->uploadFromUrl(
            $request->input('image_url')
        );

        // Upload with a file.
        $imageModel = $this->imgur->upload(
            $request->file('image')
        );

        return $imageModel;
    }
}

```

## Installation

### Step 1
Add `ozankurt/imgur-laravel` to your composer requirements.

```php
composer require ozankurt/imgur-laravel
```

### Step 2
Add the `imgur.client_id` and `imgur.client_secret` to the `config/services.php` file.

```php
    'imgur' => [
        'client_id' => env('IMGUR_CLIENT_ID'),
        'client_secret' => env('IMGUR_CLIENT_SECRET'),
    ],
```
### Step 3
Update your `.env` file with the values you get from imgur.

You can create the imgur application from [here](https://api.imgur.com/oauth2/addclient).

```php
IMGUR_CLIENT_ID=
IMGUR_CLIENT_SECRET=
```

### Step 4
Add the service provider to the `config/app.php` file.

```php
    'providers' => [
        // ...

        Kurt\Imgur\ImgurServiceProvider::class,
    ],
```
