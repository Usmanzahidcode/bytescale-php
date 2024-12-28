<?php

namespace AlgoBox\Bytescale;

use AlgoBox\Bytescale\Client\BytescaleClient;
use Illuminate\Support\ServiceProvider;

class BytescaleServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->singleton('bytescale', BytescaleClient::class);
    }

    public function boot(): void {
        //
    }
}