<?php

namespace Kurt\Imgur\Exceptions;

class NonexistentApiException extends \Exception {

    function __construct($apiName)
    {
        $this->message = "The `{$apiName}` api does not exist.";
    }

}
