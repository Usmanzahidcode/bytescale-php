<?php declare(strict_types=1);

namespace UsmanZahid\Bytescale;

use UsmanZahid\Bytescale\Client\BytescaleUploadClient;

/**
 * Will have static methods to get the actual client and make requests.
 */
class BytescaleService {
    public static function upload(): BytescaleUploadClient {
        return new BytescaleUploadClient();
    }
}