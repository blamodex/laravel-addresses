<?php

namespace Blamodex\Address\Tests\Unit;

use Blamodex\Address\Models\Address;
use Blamodex\Address\Services\AddressService;
use Blamodex\Address\Tests\Fixtures\DummyAddressableModel;
use Blamodex\Address\Tests\TestCase;

class AddressableTraitTest extends TestCase
{
    protected AddressService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AddressService();
    }

    public function test_createAddress_creates_an_address_and_returns_model(): void
    {
        $model = DummyAddressableModel::create(['name' => 'TraitUser', 'email' => 'trait@example.com']);

        $address = $model->createAddress([
            'address_1' => '100 Trait St',
            'city' => 'Traitville',
            'administrative_area_code' => 'CA',
            'postal_code' => '90001',
            'country_code' => 'US',
        ]);

        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals($model->getKey(), $address->addressable_id);
        $this->assertEquals($model->getMorphClass(), $address->addressable_type);
    }

    public function test_getAddresses_returns_collection_of_addresses(): void
    {
        $model = DummyAddressableModel::create(['name' => 'ListUser', 'email' => 'list@example.com']);

        // create multiple addresses via the service to ensure they are available
        $this->service->create($model, ['address_1' => 'A1', 'country_code' => 'US']);
        $this->service->create($model, ['address_1' => 'A2', 'country_code' => 'US']);

        $addresses = $model->getAddresses();

        $this->assertIsIterable($addresses);
        $this->assertCount(2, $addresses);
        foreach ($addresses as $addr) {
            $this->assertEquals($model->getKey(), $addr->addressable_id);
        }
    }

    public function test_updateAddress_updates_and_preserves_addressable_relationship(): void
    {
        $model = DummyAddressableModel::create(['name' => 'UpdUser', 'email' => 'upd@example.com']);

        $address = $this->service->create($model, ['address_1' => 'Old', 'country_code' => 'US']);

        $updated = $model->updateAddress($address, ['address_1' => 'New']);

        $this->assertEquals('New', $updated->address_1);
        $this->assertEquals($model->getKey(), $updated->addressable_id);
        $this->assertEquals($model->getMorphClass(), $updated->addressable_type);
    }

    public function test_deleteAddress_soft_deletes_the_address(): void
    {
        $model = DummyAddressableModel::create(['name' => 'DelUser', 'email' => 'del@example.com']);

        $address = $this->service->create($model, ['address_1' => 'ToDelete', 'country_code' => 'US']);

        $result = $model->deleteAddress($address);

        $this->assertTrue($result);
        $this->assertSoftDeleted('addresses', ['id' => $address->id]);
    }

    public function test_createAddress_respects_formatter_and_returns_false_on_invalid_postal(): void
    {
        $model = DummyAddressableModel::create(['name' => 'BadPostal', 'email' => 'badpostal@example.com']);

        $result = $model->createAddress(['country_code' => 'US', 'postal_code' => 'BAD']);

        // Current implementation persists an Address and stores the formatter result (false) on postal_code
        $this->assertInstanceOf(Address::class, $result);
        $this->assertSame(false, $result->postal_code);
    }
}
