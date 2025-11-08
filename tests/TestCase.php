<?php

declare(strict_types=1);

namespace Blamodex\Address\Tests;

use Blamodex\Address\AddressServiceProvider;
use Blamodex\Address\Database\Seeders\AdminstrativeAreaSeeder;
use Blamodex\Address\Database\Seeders\CountrySeeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

        // Run the migrations (use glob to tolerate timestamp variations)
        $countriesMigration = glob(__DIR__ . '/../database/migrations/*_create_countries_table.php')[0] ?? null;
        if ($countriesMigration) {
            $migration = require $countriesMigration;
            $migration->up();
        }

        $adminMigration = glob(__DIR__ . '/../database/migrations/*_create_administrative_areas_table.php')[0] ?? null;
        if ($adminMigration) {
            $migration = require $adminMigration;
            $migration->up();
        }

        $addressesMigration = glob(__DIR__ . '/../database/migrations/*_create_addresses_table.php')[0] ?? null;
        if ($addressesMigration) {
            $migration = require $addressesMigration;
            $migration->up();
        }

        // Seed only a minimal set of countries and administrative areas used by tests
        $countries = [
            ['code' => 'US', 'name' => 'United States'],
            ['code' => 'CA', 'name' => 'Canada'],
            ['code' => 'BR', 'name' => 'Brazil'],
        ];

        $adminAreas = [
            'US' => [
                ['code' => 'CA', 'name' => 'California'],
                ['code' => 'NY', 'name' => 'New York'],
                ['code' => 'IL', 'name' => 'Illinois'],
                ['code' => 'NV', 'name' => 'Nevada'],
                ['code' => 'AZ', 'name' => 'Arizona'],
                ['code' => 'TX', 'name' => 'Texas'],
                ['code' => 'WA', 'name' => 'Washington'],
                ['code' => 'OR', 'name' => 'Oregon'],
            ],
            'CA' => [
                ['code' => 'ON', 'name' => 'Ontario'],
                ['code' => 'AB', 'name' => 'Alberta'],
            ],
            'BR' => [
                ['code' => 'SP', 'name' => 'São Paulo'],
            ],
        ];

        foreach ($countries as $c) {
            DB::table('countries')->updateOrInsert(
                ['code' => $c['code']],
                [
                    'uuid' => (string) Str::orderedUuid(),
                    'name' => $c['name'],
                    'code' => $c['code'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Insert administrative areas for the seeded countries
        foreach ($adminAreas as $countryCode => $areas) {
            $country = DB::table('countries')->where('code', $countryCode)->first();
            if (! $country) {
                continue;
            }

            foreach ($areas as $area) {
                DB::table('administrative_areas')->updateOrInsert(
                    ['country_id' => $country->id, 'code' => $area['code']],
                    [
                    'uuid' => (string) Str::orderedUuid(),
                        'country_id' => $country->id,
                        'name' => $area['name'],
                        'code' => $area['code'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

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
