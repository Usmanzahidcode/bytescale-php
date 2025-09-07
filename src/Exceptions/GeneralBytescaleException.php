<?php

declare(strict_types=1);

namespace UsmanZahid\Bytescale\Exceptions;

use Exception;

// Responses like the n8n sdk might be better.
// Or maybe we can have custom exceptions for the SDK.
class GeneralBytescaleException extends Exception {
    public function __construct(
        string     $message = "A general Bytescale error has occurred.",
        int        $code = 0,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
