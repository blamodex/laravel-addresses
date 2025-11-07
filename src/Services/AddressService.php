<?php

namespace Blamodex\Address\Services;

use Blamodex\Address\Contracts\AddressableInterface;
use Blamodex\Address\Models\Address;
use Blamodex\Address\Models\AdministrativeArea;
use Blamodex\Address\Models\Country;
use Illuminate\Database\Eloquent\Collection;
use Blamodex\Address\Utils\PostalCodeFormatter;

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
     * @return Address|false
     */
    public function create(AddressableInterface $addressable, array $attributes): Address|false
    {
        $country = null;

        if (!empty($attributes['country_name'])) {
            $country = Country::where('name', $attributes['country_name'])->first();
        }

        if (!empty($attributes['country_code'])) {
            $country = Country::where('code', $attributes['country_code'])->first();
        }

        if (!empty($attributes['administrative_area_name'])) {
            $administrativeArea = AdministrativeArea::where('name', $attributes['administrative_area_name'])->first();
        }

        if (!empty($attributes['administrative_area_code'])) {
            $administrativeArea = AdministrativeArea::where('code', $attributes['administrative_area_code'])->first();
        }

        if (isset($country) && isset($administrativeArea)) {
            if ($administrativeArea->country_id !== $country->id) {
                // Mismatch between country and administrative area
                throw new \InvalidArgumentException('Mismatch between country and administrative area');
            }
        }

        $countryCode = $country ? $country->code : 'CA';

        if (isset($attributes['postal_code'])) {
            $postalCode = PostalCodeFormatter::format($attributes['postal_code'], $countryCode);
        }

        $address = new Address();
        $address->addressable_id = $addressable->getKey();
        $address->addressable_type = $addressable->getMorphClass();
        $address->address_1 = $attributes['address_1'] ?? null;
        $address->address_2 = $attributes['address_2'] ?? null;
        $address->city = $attributes['city'] ?? null;
        if (isset($administrativeArea)) {
            $address->administrative_area_id = $administrativeArea->id;
        }
        if (isset($country)) {
            $address->country_id = $country->id;
        }
        $address->postal_code = $postalCode ?? null;
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
        $country = null;
        $administrativeArea = null;
        $postalCode = null;

        if (!empty($attributes['country_name'])) {
            $country = Country::where('name', $attributes['country_name'])->first();
        }

        if (!empty($attributes['country_code'])) {
            $country = Country::where('code', $attributes['country_code'])->first();
        }

        if (!empty($attributes['administrative_area_name'])) {
            $administrativeArea = AdministrativeArea::where('name', $attributes['administrative_area_name'])->first();
        }

        if (!empty($attributes['administrative_area_code'])) {
            $administrativeArea = AdministrativeArea::where('code', $attributes['administrative_area_code'])->first();
        }

        if ($country && $administrativeArea) {
            if ($administrativeArea->country_id !== $country->id) {
                throw new \InvalidArgumentException('Mismatch between country and administrative area');
            }
        }

        $countryCode = $country ? $country->code : null;

        if (!empty($attributes['postal_code'])) {
            $postalCode = PostalCodeFormatter::format($attributes['postal_code'], $countryCode);
        }

        $address->address_1 = $attributes['address_1'] ?? $address->address_1;
        $address->address_2 = $attributes['address_2'] ?? $address->address_2;
        $address->city = $attributes['city'] ?? $address->city;
        if ($administrativeArea) {
            $address->administrative_area_id = $administrativeArea->id;
        }
        if ($country) {
            $address->country_id = $country->id;
        }
        $address->postal_code = $postalCode ?? $address->postal_code;
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
