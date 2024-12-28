<?php

namespace AlgoBox\Bytescale\Providers;

use AlgoBox\Bytescale\Client\BytescaleClient;
use Illuminate\Support\ServiceProvider;

class BytescaleServiceProvider extends ServiceProvider {
    public function boot(): void {
        $this->publishes([
            __DIR__ . '/../Config/bytescale.php' => config_path('bytescale.php'),
        ], 'config');
    }

    public function register(): void {
        $this->app->singleton('bytescale', BytescaleClient::class);
    }
}
