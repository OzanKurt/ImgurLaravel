<?php

namespace Kurt\Imgur\Exceptions;

use Exception;

class UploadFailedException extends Exception
{
    protected $message = "The given file could not be uploaded, check your credentials and input data.";
}
