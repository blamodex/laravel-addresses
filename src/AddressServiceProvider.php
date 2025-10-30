<?php

namespace Blamodex\Address;

use Illuminate\Support\ServiceProvider;

/**
 * Service provider for the Address package.
 *
 * Handles the registration and bootstrapping of package services,
 * including configuration merging and migration loading.
 */
class AddressServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * This is where bindings, singletons, and config merging should happen.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/address.php', 'blamodex.address');
    }

    /**
     * Bootstrap any package services.
     *
     * This is where you load migrations, publish configs, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/address.php' => config_path('address.php'),
        ], 'blamodex-address-config');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
