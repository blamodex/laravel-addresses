<?php

namespace Blamodex\Address\Traits;

use Blamodex\Address\Contracts\AddressableInterface;
use Blamodex\Address\Models\Address;
use Blamodex\Address\Services\AddressService;
use Illuminate\Database\Eloquent\Collection;

/**
 * @mixin \Blamodex\Address\Contracts\AddressableInterface
 */
class Addressable
{
    /**
     * Store a new address
     *
     * @param array<mixed> $attributes
     * @return Address|false
     * @phpstan-this \Blamodex\Address\Contracts\AddressableInterface
     */
    public function createAddress(array $attributes): \Blamodex\Address\Models\Address|false
    {
        return app(\Blamodex\Address\Services\AddressService::class)->create($this, $attributes);
    }

    /**
     * Update an address
     *
     * @param Address $address
     * @param array<mixed> $attributes
     * @return Address
     */
    public function updateAddress(Address $address, array $attributes): Address
    {
        return app(AddressService::class)->update($address, $attributes);
    }

    /**
     * Delete an address
     *
     * @param Address $address
     * @return bool
     */
    public function deleteAddress(Address $address): bool
    {
        return app(AddressService::class)->delete($address);
    }

    /**
     * Return a list of addresses
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Address>
     * @phpstan-this \Blamodex\Address\Contracts\AddressableInterface
     */
    public function getAddresses(): \Illuminate\Database\Eloquent\Collection
    {
        return app(\Blamodex\Address\Services\AddressService::class)->listByAddressable($this);
    }
}
