<?php

namespace UsmanZahid\Bytescale\Contracts;

// Contracts is good.
interface BytescaleContract {
    public function upload(string $file): string;
}