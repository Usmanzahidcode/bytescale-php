<?php

namespace AlgoBox\Bytescale\Tests\Unit;

use AlgoBox\Bytescale\Client\BytescaleClient;
use AlgoBox\Bytescale\Exceptions\GeneralBytescaleException;
use PHPUnit\Framework\TestCase;

class BytescaleClientTest extends TestCase {
    public function testUploadSuccess() {
        $client = $this->createPartialMock(BytescaleClient::class, ['upload']);
        $client->method('upload')->willReturn('File has been uploaded');

        $result = $client->upload('path/to/file.jpg');
        $this->assertSame('File has been uploaded', $result, 'The upload response should match.');
    }

    public function testUploadThrowsException() {
        $this->expectException(GeneralBytescaleException::class);
        $this->expectExceptionMessage('Error during cURL request:');

        $client = $this->createPartialMock(BytescaleClient::class, ['upload']);
        $client->method('upload')->will($this->throwException(new GeneralBytescaleException('Error during cURL request: Test error')));

        $client->upload('path/to/file.jpg');
    }
}
