<?php

namespace AlgoBox\Bytescale\Tests\Unit;

use AlgoBox\Bytescale\Client\BytescaleClient;
use PHPUnit\Framework\TestCase;

class BytescaleClientTest extends TestCase {
    public function testUpload() {
        $result = (new BytescaleClient())->upload('path/to/file.jpg');
        $this->assertIsString($result);
    }
}
