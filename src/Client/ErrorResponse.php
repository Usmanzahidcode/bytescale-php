<?php

namespace UsmanZahid\Bytescale\Client;

class ErrorResponse {
    public string $code;
    public string $message;
    public array $details;

    public function __construct(
        string $code,
        string $message,
        array  $details = []
    ) {
        $this->code = $code;
        $this->message = $message;
        $this->details = $details;
    }
}