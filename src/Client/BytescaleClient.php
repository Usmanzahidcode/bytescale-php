<?php

namespace AlgoBox\Bytescale\Client;

use AlgoBox\Bytescale\Contracts\BytescaleContract;

class BytescaleClient implements BytescaleContract {
    public function upload(string $file): string {
        return 'File has been uploaded';
    }
}