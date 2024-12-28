<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Bytescale API Key
    |--------------------------------------------------------------------------
    |
    | This value is used to authenticate with the Bytescale service. You should
    | set this value in your .env file to enable communication with Bytescale's
    | API. If the value is not set, a default empty string will be used.
    |
    */

    'api_key' => env('BYTESCALE_API_KEY', ''),
];
