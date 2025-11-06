<?php

namespace Blamodex\Address\Traits;

use Blamodex\Address\Contracts\AddressableInterface;
use Blamodex\Address\Models\Address;
use Blamodex\Address\Services\AddressService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Addressable
{
    /**
     * Define the addresses relation for addressable models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<\Blamodex\Address\Models\Address, static>
     */
    public function addresses(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Store a new address
     *
     * @param array<mixed> $attributes
     * @return Address|false
     */
    public function createAddress(array $attributes): Address|false
    {
        return app(AddressService::class)->create($this, $attributes);
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
     */
    public function getAddresses(): Collection
    {
        return app(AddressService::class)->listByAddressable($this);
    }
}
