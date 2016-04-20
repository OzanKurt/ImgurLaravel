<?php

namespace Kurt\Imgur\Exceptions;

/**
 * Custom exception for more information.
 *
 * @author Ozan Kurt <ozankurt2@gmail.com>
 * @package ozankurt/imgur-laravel
 * @version 1.0.1
 */
class UploadFailedException extends \Exception {

    protected $message = "The given file could not be uploaded, check your credentials and input data.";

}
