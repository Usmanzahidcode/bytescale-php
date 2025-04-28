<?php

namespace UsmanZahid\Bytescale\Tests\Unit;

use PHPUnit\Framework\TestCase;
use UsmanZahid\Bytescale\Client\Upload\BytescaleUploadClient;

class BytescaleUploadClientTest extends TestCase {
    public function testUploadIsWorking() {
        $client = new BytescaleUploadClient(
            getenv('ACCOUNT_ID'),
            getenv('SECRET_KEY'),
        );

        $response = $client->withSourceFilePath(__DIR__ . '/../temp/img.png')
        ->withFileName('Sending through tests!')
        ->withOriginalFileName('testing_on_rats.png');

        $response;
    }
}
