<?php

namespace UsmanZahid\Bytescale\Exceptions;

use Exception;

class BytescaleUploadException extends Exception {
    public function __construct(
        string     $message = "An error occurred during Bytescale upload.",
        int        $code = 0,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
