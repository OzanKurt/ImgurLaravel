<?php

namespace Kurt\Imgur\Exceptions;

/**
 * Custom exception for more information.
 *
 * @author Ozan Kurt <ozankurt2@gmail.com>
 * @package ozankurt/imgur-laravel
 * @version 1.0.0
 */
class NonexistentApiException extends \Exception {

    /**
     * NonexistentApiException constructor.
     * 
     * @param string $apiName Name of the api that doesn't exist.
     */
    function __construct($apiName)
    {
        $this->message = "The `{$apiName}` api does not exist.";
    }

}
