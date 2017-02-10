<?php

namespace Kurt\Imgur\Exceptions;

use Exception;

/**
 * Custom exception for more information.
 *
 * @author Ozan Kurt <ozankurt2@gmail.com>
 * @package ozankurt/imgur-laravel
 * @version 5.4.0
 */
class UploadFailedException extends Exception
{
    protected $message = "The given file could not be uploaded, check your credentials and input data.";
}
