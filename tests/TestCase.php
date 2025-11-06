<?php

namespace Blamodex\Address\Tests;

use Blamodex\Address\AddressServiceProvider;
use Blamodex\Address\Database\Seeders\AdminstrativeAreaSeeder;
use Blamodex\Address\Database\Seeders\CountrySeeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

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

        // Run the migrations
        $migration = require __DIR__ . '/../database/migrations/2025_07_04_113000_create_countries_table.php';
        $migration->up();

        $migration = require __DIR__ . '/../database/migrations/2025_07_04_113000_create_administrative_areas_table.php';
        $migration->up();

        $migration = require __DIR__ . '/../database/migrations/2025_07_04_113000_create_addresses_table.php';
        $migration->up();

        //Run the seeders
        $seeder = new \Blamodex\Address\Database\Seeders\CountrySeeder();
        $seeder->run();

        $seeder = new \Blamodex\Address\Database\Seeders\AdministrativeAreaSeeder();
        $seeder->run();

        // Create test tables for fixtures
        Schema::create('dummy_address_users', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamps();
        });

        Schema::create('dummy_address_companies', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('industry')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
