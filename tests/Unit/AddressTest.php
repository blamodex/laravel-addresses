<?php

namespace Blamodex\Address\Tests\Unit;

use Blamodex\Address\Models\Address;
use Blamodex\Address\Tests\Fixtures\DummyAddressCompany;
use Blamodex\Address\Tests\Fixtures\DummyAddressUser;
use Blamodex\Address\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AddressTest extends TestCase
{
    /**
     * It returns correct MorphTo relation for addressable
     */
    public function test_addressable_relation_returns_morph_to(): void
    {
        $address = new Address();
        
        $relation = $address->addressable();
        
        $this->assertInstanceOf(MorphTo::class, $relation);
    }

    /**
     * It retrieves correct addressable entity through relation
     */
    public function test_addressable_relation_retrieves_correct_entity(): void
    {
        $user = DummyAddressUser::create(['name' => 'John Doe', 'email' => 'john@example.com']);

        $address = new Address();
        $address->fill([
            'address_1' => '123 Main St',
            'city' => 'New York',
            'subnation' => 'NY',
            'postal_code' => '10001',
            'country' => 'USA',
        ]);
        $address->addressable_id = $user->getKey();
        $address->addressable_type = $user->getMorphClass();
        $address->save();

        // Test relation retrieval
        $retrievedAddressable = $address->addressable;

        $this->assertInstanceOf(DummyAddressUser::class, $retrievedAddressable);
        $this->assertEquals($user->id, $retrievedAddressable->id);
        $this->assertEquals($user->name, $retrievedAddressable->name);
        $this->assertEquals($user->email, $retrievedAddressable->email);
    }

    /**
     * It retrieves different addressable entity types correctly
     */
    public function test_addressable_relation_handles_different_entity_types(): void
    {
        $user = DummyAddressUser::create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);
        $company = DummyAddressCompany::create(['name' => 'Tech Corp', 'industry' => 'Technology']);

        $userAddress = new Address();
        $userAddress->fill([
            'address_1' => '456 User Ave',
            'city' => 'Boston',
            'subnation' => 'MA',
            'postal_code' => '02101',
            'country' => 'USA',
        ]);
        $userAddress->addressable_id = $user->getKey();
        $userAddress->addressable_type = $user->getMorphClass();
        $userAddress->save();

        $companyAddress = new Address();
        $companyAddress->fill([
            'address_1' => '789 Company Blvd',
            'city' => 'Seattle',
            'subnation' => 'WA',
            'postal_code' => '98101',
            'country' => 'USA',
        ]);
        $companyAddress->addressable_id = $company->getKey();
        $companyAddress->addressable_type = $company->getMorphClass();
        $companyAddress->save();

        // Test user address
        $this->assertInstanceOf(DummyAddressUser::class, $userAddress->addressable);
        $this->assertEquals($user->id, $userAddress->addressable->id);

        // Test company address
        $this->assertInstanceOf(DummyAddressCompany::class, $companyAddress->addressable);
        $this->assertEquals($company->id, $companyAddress->addressable->id);
    }

    /**
     * It supports eager loading for addressable relation
     */
    public function test_addressable_relation_supports_eager_loading(): void
    {
        $user = DummyAddressUser::create(['name' => 'Bob Jones', 'email' => 'bob@example.com']);

        $address = new Address();
        $address->fill([
            'address_1' => '321 Eager St',
            'city' => 'Chicago',
            'subnation' => 'IL',
            'postal_code' => '60601',
            'country' => 'USA',
        ]);
        $address->addressable_id = $user->getKey();
        $address->addressable_type = $user->getMorphClass();
        $address->save();

        // Test eager loading
        $addressWithAddressable = Address::with('addressable')->find($address->id);
        
        $this->assertTrue($addressWithAddressable->relationLoaded('addressable'));
        $this->assertInstanceOf(DummyAddressUser::class, $addressWithAddressable->addressable);
        $this->assertEquals($user->id, $addressWithAddressable->addressable->id);
    }

    /**
     * It returns null when addressable entity is deleted
     */
    public function test_addressable_relation_returns_null_when_entity_deleted(): void
    {
        $user = DummyAddressUser::create(['name' => 'Alice Brown', 'email' => 'alice@example.com']);

        $address = new Address();
        $address->fill([
            'address_1' => '555 Orphan St',
            'city' => 'Portland',
            'subnation' => 'OR',
            'postal_code' => '97201',
            'country' => 'USA',
        ]);
        $address->addressable_id = $user->getKey();
        $address->addressable_type = $user->getMorphClass();
        $address->save();

        // Delete the user
        $user->delete();

        // Refresh address and test relation
        $address->refresh();
        
        $this->assertNull($address->addressable);
    }

    /**
     * It generates UUID automatically on creation
     */
    public function test_generates_uuid_automatically_on_creation(): void
    {
        $user = DummyAddressUser::create(['name' => 'Charlie Davis', 'email' => 'charlie@example.com']);

        $address = new Address();
        $address->fill([
            'address_1' => '777 UUID Ave',
            'city' => 'Denver',
            'subnation' => 'CO',
            'postal_code' => '80201',
            'country' => 'USA',
        ]);
        $address->addressable_id = $user->getKey();
        $address->addressable_type = $user->getMorphClass();
        $address->save();

        $this->assertNotNull($address->uuid);
        $this->assertIsString($address->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $address->uuid
        );
    }

    /**
     * It preserves existing UUID if provided
     */
    public function test_preserves_existing_uuid_if_provided(): void
    {
        $user = DummyAddressUser::create(['name' => 'Diana Evans', 'email' => 'diana@example.com']);
        $customUuid = '12345678-1234-1234-1234-123456789012';

        $address = new Address();
        $address->uuid = $customUuid;
        $address->fill([
            'address_1' => '888 Custom UUID St',
            'city' => 'Miami',
            'subnation' => 'FL',
            'postal_code' => '33101',
            'country' => 'USA',
        ]);
        $address->addressable_id = $user->getKey();
        $address->addressable_type = $user->getMorphClass();
        $address->save();

        $this->assertEquals($customUuid, $address->uuid);
    }

    /**
     * It uses SoftDeletes trait correctly
     */
    public function test_uses_soft_deletes_correctly(): void
    {
        $user = DummyAddressUser::create(['name' => 'Eve Foster', 'email' => 'eve@example.com']);

        $address = new Address();
        $address->fill([
            'address_1' => '999 Soft Delete Ave',
            'city' => 'Austin',
            'subnation' => 'TX',
            'postal_code' => '78701',
            'country' => 'USA',
        ]);
        $address->addressable_id = $user->getKey();
        $address->addressable_type = $user->getMorphClass();
        $address->save();

        $addressId = $address->id;

        // Soft delete
        $address->delete();

        // Verify soft deleted
        $this->assertSoftDeleted('addresses', ['id' => $addressId]);
        $this->assertNotNull($address->deleted_at);

        // Verify can still access with trashed
        $trashedAddress = Address::withTrashed()->find($addressId);
        $this->assertNotNull($trashedAddress);
        $this->assertNotNull($trashedAddress->deleted_at);
    }

    /**
     * It respects mass assignment protection
     */
    public function test_respects_mass_assignment_protection(): void
    {
        $user = DummyAddressUser::create(['name' => 'Frank Green', 'email' => 'frank@example.com']);

        $address = new Address();
        $address->fill([
            'address_1' => '111 Protected St',
            'city' => 'Phoenix',
            'subnation' => 'AZ',
            'postal_code' => '85001',
            'country' => 'USA',
            'uuid' => 'should-be-ignored', // UUID is not in fillable
        ]);
        $address->addressable_id = $user->getKey();
        $address->addressable_type = $user->getMorphClass();
        $address->save();

        // UUID should be auto-generated, not the value we tried to fill
        $this->assertNotEquals('should-be-ignored', $address->uuid);
    }

    /**
     * It can query addresses by addressable using relation
     */
    public function test_can_query_addresses_by_addressable(): void
    {
        $user1 = DummyAddressUser::create(['name' => 'George Hill', 'email' => 'george@example.com']);
        $user2 = DummyAddressUser::create(['name' => 'Helen Iris', 'email' => 'helen@example.com']);

        // Create addresses for user1
        $address1 = new Address();
        $address1->fill([
            'address_1' => '123 Query St',
            'city' => 'City1',
            'subnation' => 'CA',
            'postal_code' => '90001',
            'country' => 'USA',
        ]);
        $address1->addressable_id = $user1->getKey();
        $address1->addressable_type = $user1->getMorphClass();
        $address1->save();

        // Create address for user2
        $address2 = new Address();
        $address2->fill([
            'address_1' => '456 Query Ave',
            'city' => 'City2',
            'subnation' => 'NY',
            'postal_code' => '10001',
            'country' => 'USA',
        ]);
        $address2->addressable_id = $user2->getKey();
        $address2->addressable_type = $user2->getMorphClass();
        $address2->save();

        // Query using whereHasMorph
        $user1Addresses = Address::whereHasMorph('addressable', DummyAddressUser::class, function ($query) use ($user1) {
            $query->where('id', $user1->id);
        })->get();

        $this->assertCount(1, $user1Addresses);
        $this->assertEquals($address1->id, $user1Addresses->first()->id);
    }
}
