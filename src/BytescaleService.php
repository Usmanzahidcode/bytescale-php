<?php declare(strict_types=1);

namespace UsmanZahid\Bytescale;

use UsmanZahid\Bytescale\Client\BytescaleClient;

/**
 * Will have static methods to get the actual client and make requests.
 */
class BytescaleService {
    public static function image(): BytescaleClient {
        return new BytescaleClient();
    }
}