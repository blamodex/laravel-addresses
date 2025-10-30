<?php

namespace Blamodex\Address\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Blamodex\Address\AddressServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            AddressServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $migration = require __DIR__ . '/../database/migrations/2025_07_04_113000_create_addresses_table.php';
        $migration->up();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
