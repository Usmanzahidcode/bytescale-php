<?php declare(strict_types=1);

namespace UsmanZahid\Bytescale;

use UsmanZahid\Bytescale\Client\Upload\BytescaleUploadClient;

/**
 * Will have static methods to get the actual client and make requests.
 */
class BytescaleService {
    /**
     * Get a new UploadClient instance for uploading files.
     *
     * @param string $accountId
     * @param string $apiKey
     * @return BytescaleUploadClient
     */
    public static function upload(
        string $accountId,
        string $apiKey,
    ): BytescaleUploadClient {
        return new BytescaleUploadClient($accountId, $apiKey);
    }
}