<?php

namespace AlgoBox\Bytescale\Client;

use AlgoBox\Bytescale\Exceptions\GeneralBytescaleException;

class BytescaleClient {
    private string $bytescaleBaseUrl = "https://api.bytescale.com";
    private string $bytescaleUploadPath = "/v2/accounts/accountId/uploads/binary";
    private string $bytescaleProcessingUrl = "https://upcdn.io";

    public function __construct() {
        str_replace('accountId', config('bytescale.account_id'), $this->bytescaleUploadPath);
    }

    /**
     * @throws GeneralBytescaleException
     */
    public function upload(mixed $file): string {
        // Initialize cURL
        $ch = curl_init();

        // Bytescale API endpoint for file upload
        $url = $this->bytescaleBaseUrl . $this->bytescaleUploadPath;

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        // Prepare file data (assuming $file is a file path or resource)
        $fileData = [
            'file' => new \CURLFile($file) // Wrap the file path in CURLFile
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, $fileData);

        // Execute the request
        $response = curl_exec($ch);

        // Handle errors
        if (curl_errno($ch)) {
            throw new GeneralBytescaleException(
                'Error during cURL request: ' . curl_error($ch)
            );
        }

        // Close cURL session
        curl_close($ch);

        return $response ?:'No response received.';
    }

}
