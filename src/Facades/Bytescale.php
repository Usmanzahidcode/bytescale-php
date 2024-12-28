<?php

namespace AlgoBox\Bytescale\Facades;

use Illuminate\Support\Facades\Facade;

class Bytescale extends Facade {
    protected static function getFacadeAccessor(): string {
        return 'bytescale';
    }
}