<?php

namespace AlgoBox\Bytescale\Contracts;

interface BytescaleContract {
    public function upload(string $file): string;
}