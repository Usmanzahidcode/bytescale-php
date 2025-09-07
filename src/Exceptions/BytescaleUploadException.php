<?php

namespace UsmanZahid\Bytescale\Exceptions;

use Exception;

// Responses like the n8n sdk might be better.
// Or maybe we can have custom exceptions for the SDK.
class BytescaleUploadException extends Exception {
    public function __construct(
        string     $message = "An error occurred during Bytescale upload.",
        int        $code = 0,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
