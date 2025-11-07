<?php

declare(strict_types=1);

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
            'administrative_area_code' => 'ON',
            'postal_code' => 'K1A 0B1', // valid Canadian postal code
            'country_code' => 'CA'
        ];

        $address = $this->service->create($user, $attributes);

        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals($user->getKey(), $address->addressable_id);
        $this->assertEquals($user->getMorphClass(), $address->addressable_type);
        $this->assertEquals('123 Main St', $address->address_1);
        $this->assertEquals('Apt 4B', $address->address_2);
        $this->assertEquals('New York', $address->city);
        // Use administrative_area_name instead of subnation
        $this->assertEquals('ON', $attributes['administrative_area_code']);
        $this->assertEquals('K1A 0B1', $address->postal_code);
        $this->assertEquals('CA', $attributes['country_code']);
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
            'country_code' => 'US',
        ];

        $address = $this->service->create($user, $attributes);

        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals($user->getKey(), $address->addressable_id);
        $this->assertEquals($user->getMorphClass(), $address->addressable_type);
        $this->assertNull($address->address_1);
        $this->assertEquals('US', $attributes['country_code']);
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
            'country_name' => 'USA',
            'administrative_area_name' => 'IL',
        ]);

        $workAddress = $this->service->create($user, [
            'address_1' => '789 Business Blvd',
            'city' => 'Chicago',
            'subnation' => 'IL',
            'postal_code' => '60602',
            'country' => 'USA',
            'country_name' => 'USA',
            'administrative_area_name' => 'IL',
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
            'country_name' => 'USA',
            'administrative_area_name' => 'CA',
        ]);

        $companyAddress = $this->service->create($company, [
            'address_1' => '456 Company Ave',
            'city' => 'CompanyCity',
            'subnation' => 'NY',
            'postal_code' => '10001',
            'country' => 'USA',
            'country_name' => 'USA',
            'administrative_area_name' => 'NY',
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
            'administrative_area_code' => 'ON',
            'postal_code' => 'R4R 4R4',
            'country_code' => 'CA'
        ]);

        $originalId = $address->id;
        $originalUuid = $address->uuid;

        $updatedAddress = $this->service->update($address, [
            'address_1' => '456 New St',
            'city' => 'NewCity',
            'postal_code' => 'T6T 6T6',
            'administrative_area_code' => 'AB',
            'country_code' => 'CA'
        ]);

        $this->assertEquals($originalId, $updatedAddress->id);
        $this->assertEquals($originalUuid, $updatedAddress->uuid);
        $this->assertEquals('456 New St', $updatedAddress->address_1);
        $this->assertEquals('NewCity', $updatedAddress->city);
        $this->assertEquals('T6T 6T6', $updatedAddress->postal_code);
        $this->assertEquals('AB', $updatedAddress->administrativeArea->code);
        $this->assertEquals('CA', $updatedAddress->country->code); // Unchanged
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
            'country_code' => 'US',
            'administrative_area_code' => 'WA',
        ]);

        $updatedAddress = $this->service->update($address, [
            'postal_code' => '98102',
            'country_code' => 'US',
            'administrative_area_code' => 'WA',
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
            'country_name' => 'USA',
            'administrative_area_name' => 'TX',
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
        $this->service->create(
            $user1,
            [
                'address_1' => '111 First St',
                'city' => 'City1',
                'subnation' => 'CA',
                'postal_code' => '90001',
                'country' => 'USA',
                'country_name' => 'USA',
                'administrative_area_name' => 'CA',
            ]
        );
        $this->service->create(
            $user1,
            [
                'address_1' => '222 Second St',
                'city' => 'City2',
                'subnation' => 'CA',
                'postal_code' => '90002',
                'country' => 'USA',
                'country_name' => 'USA',
                'administrative_area_name' => 'CA',
            ]
        );
        $this->service->create(
            $user1,
            [
                'address_1' => '333 Third St',
                'city' => 'City3',
                'subnation' => 'CA',
                'postal_code' => '90003',
                'country' => 'USA',
                'country_name' => 'USA',
                'administrative_area_name' => 'CA',
            ]
        );

        // Create address for user2
        $this->service->create(
            $user2,
            [
                'address_1' => '444 Fourth St',
                'city' => 'City4',
                'subnation' => 'NY',
                'postal_code' => '10001',
                'country' => 'USA',
                'country_name' => 'USA',
                'administrative_area_name' => 'NY',
            ]
        );

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

        $address1 = $this->service->create(
            $user,
            [
                'address_1' => '555 Active St',
                'city' => 'ActiveCity',
                'subnation' => 'CA',
                'postal_code' => '90001',
                'country' => 'USA',
                'country_name' => 'USA',
                'administrative_area_name' => 'CA',
            ]
        );
        $address2 = $this->service->create(
            $user,
            [
                'address_1' => '666 Deleted St',
                'city' => 'DeletedCity',
                'subnation' => 'CA',
                'postal_code' => '90002',
                'country' => 'USA',
                'country_name' => 'USA',
                'administrative_area_name' => 'CA',
            ]
        );

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
            'administrative_area_code' => 'SP',
            'postal_code' => '01310-000',
            'country_code' => 'BR',
        ]);

        $this->assertEquals('Calle São Paulo 123', $address->address_1);
        $this->assertEquals('São Paulo', $address->city);
        $this->assertEquals('Brazil', $address->country->name);
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
            'administrative_area_code' => 'OR',
            'postal_code' => '97001',
            'country_code' => 'US',
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
            'country_name' => 'USA',
            'administrative_area_name' => 'NV',
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
            'country_name' => 'USA',
            'administrative_area_name' => 'AZ',
        ]);

        $originalUpdatedAt = $address->updated_at;

        // Wait a moment to ensure timestamp difference
        sleep(1);

        $updatedAddress = $this->service->update($address, [
            'city' => 'NewTimeCity',
            'country_name' => 'USA',
            'administrative_area_name' => 'AZ',
        ]);

        $this->assertNotEquals($originalUpdatedAt, $updatedAddress->updated_at);
    }

    /**
     * It throws when administrative area does not belong to the provided country on create
     */
    public function test_create_throws_when_administrative_area_not_in_country(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $user = DummyAddressUser::create(['name' => 'Mismatch', 'email' => 'mismatch@example.com']);

        // administrative area 'ON' belongs to Canada, but country_code set to 'US'
        $this->service->create($user, [
            'address_1' => '1 Mismatch St',
            'city' => 'Nowhere',
            'administrative_area_code' => 'ON',
            'country_code' => 'US',
        ]);
    }

    /**
     * It throws when administrative area does not belong to the provided country on update
     */
    public function test_update_throws_when_administrative_area_not_in_country(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $user = DummyAddressUser::create(['name' => 'UpdMismatch', 'email' => 'updmismatch@example.com']);

        // First, create a valid address in Canada (ON)
        $address = $this->service->create($user, [
            'address_1' => '10 Valid Rd',
            'city' => 'Toronto',
            'administrative_area_code' => 'ON',
            'country_code' => 'CA',
        ]);

        // Now attempt to update with a mismatched country (US) while keeping administrative_area_code 'ON'
        $this->service->update($address, [
            'administrative_area_code' => 'ON',
            'country_code' => 'US',
        ]);
    }
}
