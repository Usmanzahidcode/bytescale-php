<?php

namespace Unit;

use AlgoBox\Bytescale\Client\BytescaleClient;
use PHPUnit\Framework\TestCase;

class BytescaleClientTest extends TestCase {
    public function testUpload() {
        $client = new BytescaleClient();
        $result = $client->upload('path/to/file.jpg');
        $this->assertIsString($result);
    }
}
