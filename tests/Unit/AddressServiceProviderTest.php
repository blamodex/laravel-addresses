<?php

declare(strict_types=1);

namespace Blamodex\Address\Tests\Unit;

use Blamodex\Address\AddressServiceProvider;
use Blamodex\Address\Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class AddressServiceProviderTest extends TestCase
{
    /**
     * It registers the service provider correctly
     */
    public function test_service_provider_is_registered(): void
    {
        $providers = $this->app->getLoadedProviders();
        
        $this->assertArrayHasKey(AddressServiceProvider::class, $providers);
        $this->assertTrue($providers[AddressServiceProvider::class]);
    }

    /**
     * It merges configuration from package config file
     */
    public function test_merges_configuration_from_package(): void
    {
        // The config should be merged under the blamodex.address key
        $config = Config::get('blamodex.address');
        
        $this->assertIsArray($config);
        // Since the config file returns an empty array, we just verify it's loaded
        $this->assertEquals([], $config);
    }

    /**
     * It publishes config file to correct location
     */
    public function test_publishes_config_file(): void
    {
        $serviceProvider = new AddressServiceProvider($this->app);
        
        // Get the publishable configs
        $publishables = $serviceProvider::pathsToPublish(null, 'blamodex-address-config');
        
        $this->assertNotEmpty($publishables);
        
        // Check that the source and destination paths are correct
        $sourcePath = realpath(__DIR__ . '/../../src/config/address.php');
        $expectedDestination = config_path('address.php');
        
        $this->assertArrayHasKey($sourcePath, $publishables);
        $this->assertEquals($expectedDestination, $publishables[$sourcePath]);
    }

    /**
     * It sets up package configuration correctly during boot
     */
    public function test_boot_method_sets_up_package_correctly(): void
    {
        // Verify that after booting, we can access the config
        $config = config('blamodex.address');
        
        $this->assertIsArray($config);
    }
}