<?php

namespace Blamodex\Address\Services;

use Blamodex\Address\Contracts\AddressableInterface;
use Blamodex\Address\Models\Address;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service responsible for managing Addresses
 * for models that implement AddressableInterface.
 */
class AddressService
{
    /**
     * Create a new address
     *
     * @param AddressableInterface $addressable
     * @param array<mixed> $attributes
     * @return Address
     */
    public function create(AddressableInterface $addressable, array $attributes): Address
    {
        $address = new Address();
        $address->fill($attributes);
        $address->addressable_id = $addressable->getKey();
        $address->addressable_type = $addressable->getMorphClass();
        $address->save();

        return $address;
    }

    /**
     * Update an existing address
     *
     * @param Address $address
     * @param array<mixed> $attributes
     * @return Address
     */
    public function update(Address $address, array $attributes): Address
    {
        $address->fill($attributes);
        $address->save();

        return $address;
    }

    /**
     * Delete an address
     *
     * @param Address $address
     * @return bool
     */
    public function delete(Address $address): bool
    {
        return $address->delete();
    }

    /**
     * List addresses by addressable entity
     *
     * @param AddressableInterface $addressable
     * @return \Illuminate\Database\Eloquent\Collection<int, Address>
     * @phpstan-return \Illuminate\Database\Eloquent\Collection<int, \Blamodex\Address\Models\Address>
     */
    public function listByAddressable(AddressableInterface $addressable): Collection
    {
        return Address::where('addressable_id', $addressable->getKey())
            ->where('addressable_type', $addressable->getMorphClass())
            ->get();
    }
}
