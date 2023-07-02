<?php

namespace Kurt\Imgur\Exceptions;

use Exception;

class NonexistentApiException extends Exception
{
    /**
     * @param string $apiName Name of the api that doesn't exist.
     */
    function __construct($apiName)
    {
        $this->message = "The `{$apiName}` api does not exist.";
    }
}
