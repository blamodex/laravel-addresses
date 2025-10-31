<?php

namespace Blamodex\Address\Tests\Unit;

use Blamodex\Address\Models\Address;
use Blamodex\Address\Services\AddressService;
use Blamodex\Address\Tests\Fixtures\DummyAddressCompany;
use Blamodex\Address\Tests\Fixtures\DummyAddressUser;
use Blamodex\Address\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class AddressServiceTest extends TestCase
{
    protected AddressService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AddressService();
    }

    /**
     * It creates an address with all attributes
     */
    public function test_creates_address_with_all_attributes(): void
    {
        $user = DummyAddressUser::create(['name' => 'John Doe', 'email' => 'john@example.com']);

        $attributes = [
            'address_1' => '123 Main St',
            'address_2' => 'Apt 4B',
            'city' => 'New York',
            'subnation' => 'NY',
            'postal_code' => '10001',
            'country' => 'USA',
        ];

        $address = $this->service->create($user, $attributes);

        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals($user->getKey(), $address->addressable_id);
        $this->assertEquals($user->getMorphClass(), $address->addressable_type);
        $this->assertEquals('123 Main St', $address->address_1);
        $this->assertEquals('Apt 4B', $address->address_2);
        $this->assertEquals('New York', $address->city);
        $this->assertEquals('NY', $address->subnation);
        $this->assertEquals('10001', $address->postal_code);
        $this->assertEquals('USA', $address->country);
        $this->assertNotNull($address->uuid);
        $this->assertDatabaseHas('addresses', ['id' => $address->id]);
    }

    /**
     * It creates an address with minimal attributes
     */
    public function test_creates_address_with_minimal_attributes(): void
    {
        $user = DummyAddressUser::create(['name' => 'Jane Doe', 'email' => 'jane@example.com']);

        $attributes = [
            'country' => 'USA',
        ];

        $address = $this->service->create($user, $attributes);

        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals($user->getKey(), $address->addressable_id);
        $this->assertEquals($user->getMorphClass(), $address->addressable_type);
        $this->assertNull($address->address_1);
        $this->assertEquals($address->country, 'USA');
    }

    /**
     * It creates multiple addresses for same entity
     */
    public function test_creates_multiple_addresses_for_same_entity(): void
    {
        $user = DummyAddressUser::create(['name' => 'Bob Smith', 'email' => 'bob@example.com']);

        $homeAddress = $this->service->create($user, [
            'address_1' => '123 Main St',
            'city' => 'Chicago',
            'subnation' => 'IL',
            'postal_code' => '60601',
            'country' => 'USA',
        ]);

        $workAddress = $this->service->create($user, [
            'address_1' => '789 Business Blvd',
            'city' => 'Chicago',
            'subnation' => 'IL',
            'postal_code' => '60602',
            'country' => 'USA',
        ]);

        $this->assertNotEquals($homeAddress->id, $workAddress->id);
        $this->assertEquals($user->getKey(), $homeAddress->addressable_id);
        $this->assertEquals($user->getKey(), $workAddress->addressable_id);
        $this->assertDatabaseCount('addresses', 2);
    }

    /**
     * It creates addresses for different entity types
     */
    public function test_creates_addresses_for_different_entity_types(): void
    {
        $user = DummyAddressUser::create(['name' => 'Alice', 'email' => 'alice@example.com']);
        $company = DummyAddressCompany::create(['name' => 'Tech Corp', 'industry' => 'Technology']);

        $userAddress = $this->service->create($user, [
            'address_1' => '123 User St',
            'city' => 'UserCity',
            'subnation' => 'CA',
            'postal_code' => '90001',
            'country' => 'USA',
        ]);

        $companyAddress = $this->service->create($company, [
            'address_1' => '456 Company Ave',
            'city' => 'CompanyCity',
            'subnation' => 'NY',
            'postal_code' => '10001',
            'country' => 'USA',
        ]);

        $this->assertEquals($user->getMorphClass(), $userAddress->addressable_type);
        $this->assertEquals($company->getMorphClass(), $companyAddress->addressable_type);
        $this->assertNotEquals($userAddress->addressable_type, $companyAddress->addressable_type);
    }

    /**
     * It updates an address successfully
     */
    public function test_updates_address_successfully(): void
    {
        $user = DummyAddressUser::create(['name' => 'Charlie', 'email' => 'charlie@example.com']);
        
        $address = $this->service->create($user, [
            'address_1' => '123 Old St',
            'city' => 'OldCity',
            'subnation' => 'CA',
            'postal_code' => '90210',
            'country' => 'USA',
        ]);

        $originalId = $address->id;
        $originalUuid = $address->uuid;

        $updatedAddress = $this->service->update($address, [
            'address_1' => '456 New St',
            'city' => 'NewCity',
            'postal_code' => '90211',
        ]);

        $this->assertEquals($originalId, $updatedAddress->id);
        $this->assertEquals($originalUuid, $updatedAddress->uuid);
        $this->assertEquals('456 New St', $updatedAddress->address_1);
        $this->assertEquals('NewCity', $updatedAddress->city);
        $this->assertEquals('90211', $updatedAddress->postal_code);
        $this->assertEquals('CA', $updatedAddress->subnation); // Unchanged
    }

    /**
     * It updates partial address attributes
     */
    public function test_updates_partial_address_attributes(): void
    {
        $user = DummyAddressUser::create(['name' => 'Diana', 'email' => 'diana@example.com']);
        
        $address = $this->service->create($user, [
            'address_1' => '789 Park Ave',
            'city' => 'Seattle',
            'subnation' => 'WA',
            'postal_code' => '98101',
            'country' => 'USA',
        ]);

        $updatedAddress = $this->service->update($address, [
            'postal_code' => '98102',
        ]);

        $this->assertEquals('789 Park Ave', $updatedAddress->address_1); // Unchanged
        $this->assertEquals('Seattle', $updatedAddress->city); // Unchanged
        $this->assertEquals('98102', $updatedAddress->postal_code); // Changed
    }

    /**
     * It deletes an address successfully
     */
    public function test_deletes_address_successfully(): void
    {
        $user = DummyAddressUser::create(['name' => 'Eve', 'email' => 'eve@example.com']);
        
        $address = $this->service->create($user, [
            'address_1' => '321 Delete St',
            'city' => 'Deleteville',
            'subnation' => 'TX',
            'postal_code' => '75001',
            'country' => 'USA',
        ]);

        $addressId = $address->id;

        $result = $this->service->delete($address);

        $this->assertTrue($result);
        $this->assertSoftDeleted('addresses', ['id' => $addressId]);
    }

    /**
     * It lists addresses by addressable entity
     */
    public function test_lists_addresses_by_addressable_entity(): void
    {
        $user1 = DummyAddressUser::create(['name' => 'Frank', 'email' => 'frank@example.com']);
        $user2 = DummyAddressUser::create(['name' => 'Grace', 'email' => 'grace@example.com']);

        // Create addresses for user1
        $this->service->create($user1, ['address_1' => '111 First St', 'city' => 'City1', 'subnation' => 'CA', 'postal_code' => '90001', 'country' => 'USA']);
        $this->service->create($user1, ['address_1' => '222 Second St', 'city' => 'City2', 'subnation' => 'CA', 'postal_code' => '90002', 'country' => 'USA']);
        $this->service->create($user1, ['address_1' => '333 Third St', 'city' => 'City3', 'subnation' => 'CA', 'postal_code' => '90003', 'country' => 'USA']);

        // Create address for user2
        $this->service->create($user2, ['address_1' => '444 Fourth St', 'city' => 'City4', 'subnation' => 'NY', 'postal_code' => '10001', 'country' => 'USA']);

        $user1Addresses = $this->service->listByAddressable($user1);
        $user2Addresses = $this->service->listByAddressable($user2);

        $this->assertInstanceOf(Collection::class, $user1Addresses);
        $this->assertInstanceOf(Collection::class, $user2Addresses);
        $this->assertCount(3, $user1Addresses);
        $this->assertCount(1, $user2Addresses);
        
        foreach ($user1Addresses as $address) {
            $this->assertEquals($user1->getKey(), $address->addressable_id);
            $this->assertEquals($user1->getMorphClass(), $address->addressable_type);
        }
    }

    /**
     * It returns empty collection when no addresses exist
     */
    public function test_returns_empty_collection_when_no_addresses_exist(): void
    {
        $user = DummyAddressUser::create(['name' => 'Henry', 'email' => 'henry@example.com']);

        $addresses = $this->service->listByAddressable($user);

        $this->assertInstanceOf(Collection::class, $addresses);
        $this->assertCount(0, $addresses);
        $this->assertTrue($addresses->isEmpty());
    }

    /**
     * It excludes soft deleted addresses from list
     */
    public function test_excludes_soft_deleted_addresses_from_list(): void
    {
        $user = DummyAddressUser::create(['name' => 'Ivy', 'email' => 'ivy@example.com']);

        $address1 = $this->service->create($user, ['address_1' => '555 Active St', 'city' => 'ActiveCity', 'subnation' => 'FL', 'postal_code' => '33101', 'country' => 'USA']);
        $address2 = $this->service->create($user, ['address_1' => '666 Deleted St', 'city' => 'DeletedCity', 'subnation' => 'FL', 'postal_code' => '33102', 'country' => 'USA']);

        // Delete one address
        $this->service->delete($address2);

        $addresses = $this->service->listByAddressable($user);

        $this->assertCount(1, $addresses);
        $this->assertEquals($address1->id, $addresses->first()->id);
        $this->assertFalse($addresses->contains('id', $address2->id));
    }

    /**
     * It handles addresses with international characters
     */
    public function test_handles_addresses_with_international_characters(): void
    {
        $user = DummyAddressUser::create(['name' => 'José', 'email' => 'jose@example.com']);

        $address = $this->service->create($user, [
            'address_1' => 'Calle São Paulo 123',
            'city' => 'São Paulo',
            'subnation' => 'SP',
            'postal_code' => '01310-000',
            'country' => 'Brasil',
        ]);

        $this->assertEquals('Calle São Paulo 123', $address->address_1);
        $this->assertEquals('São Paulo', $address->city);
        $this->assertEquals('Brasil', $address->country);
    }

    /**
     * It preserves addressable relationship after update
     */
    public function test_preserves_addressable_relationship_after_update(): void
    {
        $user = DummyAddressUser::create(['name' => 'Karen', 'email' => 'karen@example.com']);
        
        $address = $this->service->create($user, [
            'address_1' => '777 Original St',
            'city' => 'OriginalCity',
            'subnation' => 'OR',
            'postal_code' => '97001',
            'country' => 'USA',
        ]);

        $originalAddressableId = $address->addressable_id;
        $originalAddressableType = $address->addressable_type;

        $this->service->update($address, [
            'address_1' => '888 Updated St',
        ]);

        $address->refresh();

        $this->assertEquals($originalAddressableId, $address->addressable_id);
        $this->assertEquals($originalAddressableType, $address->addressable_type);
    }

    /**
     * It creates address and persists to database
     */
    public function test_creates_address_and_persists_to_database(): void
    {
        $user = DummyAddressUser::create(['name' => 'Leo', 'email' => 'leo@example.com']);

        $address = $this->service->create($user, [
            'address_1' => '999 Persist St',
            'city' => 'PersistCity',
            'subnation' => 'NV',
            'postal_code' => '89001',
            'country' => 'USA',
        ]);

        $this->assertTrue($address->exists);
        $this->assertNotNull($address->id);
        $this->assertNotNull($address->created_at);
        $this->assertNotNull($address->updated_at);
    }

    /**
     * It updates address timestamps correctly
     */
    public function test_updates_address_timestamps_correctly(): void
    {
        $user = DummyAddressUser::create(['name' => 'Mia', 'email' => 'mia@example.com']);
        
        $address = $this->service->create($user, [
            'address_1' => '1010 Time St',
            'city' => 'TimeCity',
            'subnation' => 'AZ',
            'postal_code' => '85001',
            'country' => 'USA',
        ]);

        $originalUpdatedAt = $address->updated_at;

        // Wait a moment to ensure timestamp difference
        sleep(1);

        $updatedAddress = $this->service->update($address, [
            'city' => 'NewTimeCity',
        ]);

        $this->assertNotEquals($originalUpdatedAt, $updatedAddress->updated_at);
    }
}
