<?php

namespace Kurt\Imgur\Exceptions;

use Exception;

class InvalidAuthCredentialsException extends Exception
{
    protected $message = "The authentication credentials are invalid.";
}
