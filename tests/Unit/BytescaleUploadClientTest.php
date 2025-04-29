<?php

namespace UsmanZahid\Bytescale\Tests\Unit;

use PHPUnit\Framework\TestCase;
use UsmanZahid\Bytescale\Client\Upload\BytescaleUploadClient;
use UsmanZahid\Bytescale\Entities\BasicUploadResponse;

class BytescaleUploadClientTest extends TestCase {
    public function testUploadDoesNotWorkWithInvalidFilePath() {
        $client = new BytescaleUploadClient(
            getenv('ACCOUNT_ID'),
            getenv('SECRET_KEY'),
        );

        $this->expectException(\InvalidArgumentException::class);

        $response = $client->withSourceFilePath(__DIR__ . '/../../temp/img.png')
            ->withFileName('Sending through tests!')
            ->withOriginalFileName('testing_on_rats.png')
            ->upload();
    }

    public function testUploadWorksWithProperPayload(): void {
        $client = new BytescaleUploadClient(
            $_ENV['ACCOUNT_ID'] ?? "not_set",
            $_ENV['SECRET_API_KEY'] ?? "not_set",
        );

        $response = $client->withSourceFilePath(realpath(__DIR__ . '/../temp/img.png'))
            ->withFileName('sending-through-tests.png')
            ->withOriginalFileName('testing_on_rats.png')
            ->upload();

        $this->assertInstanceOf(BasicUploadResponse::class, $response);
        $this->assertNotEmpty($response->accountId);
        $this->assertNotEmpty($response->etag);
        $this->assertNotEmpty($response->filePath);
        $this->assertNotEmpty($response->fileUrl);
    }


}
