<?php declare(strict_types=1);

namespace UsmanZahid\Bytescale\Client;

class BytescaleUploadClient {
    private string $bytescaleBaseUrl = "https://api.bytescale.com";
    private string $bytescaleUploadPath = "/v2/accounts/{accountId}/uploads/binary";
    private string $accountId;
    private string $apiKey;

    public function __construct(
        string $accountId, $apiKey
    ) {
        $this->accountId = $accountId;
        $this->apiKey = $apiKey;

        /// Add the account ID to the Upload path.
        str_replace(
            '{accountId}',
            $accountId,
            $this->bytescaleUploadPath
        );
    }

}
