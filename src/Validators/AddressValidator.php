<?php

declare(strict_types=1);

namespace Blamodex\Address\Validators;

use Blamodex\Address\Models\Country;
use Blamodex\Address\Models\AdministrativeArea;
use Blamodex\Address\Utils\PostalCodeFormatter;

class AddressValidator
{
    /**
     * Validate address attributes.
     *
     * Returns an associative array of errors keyed by field name. Empty array = valid.
     *
     * Supported keys examined: country_code, country_name,
     * administrative_area_code, administrative_area_name, postal_code
     *
     * @param array<string,mixed> $attributes
     * @return array<string,string>
     */
    public static function validate(array $attributes): array
    {
        $errors = [];

        $country = null;
        if (!empty($attributes['country_code'])) {
            $country = Country::where('code', $attributes['country_code'])->first();
            if (!$country) {
                $errors['country_code'] = 'Unknown country code';
            }
        } elseif (!empty($attributes['country_name'])) {
            $country = Country::where('name', $attributes['country_name'])->first();
            if (!$country) {
                $errors['country_name'] = 'Unknown country name';
            }
        }

        $administrativeArea = null;
        if (!empty($attributes['administrative_area_code'])) {
            $administrativeArea = AdministrativeArea::where('code', $attributes['administrative_area_code'])->first();
            if (!$administrativeArea) {
                $errors['administrative_area_code'] = 'Unknown administrative area code';
            }
        } elseif (!empty($attributes['administrative_area_name'])) {
            $administrativeArea = AdministrativeArea::where('name', $attributes['administrative_area_name'])->first();
            if (!$administrativeArea) {
                $errors['administrative_area_name'] = 'Unknown administrative area name';
            }
        }

        if ($country && $administrativeArea) {
            if ($administrativeArea->country_id !== $country->id) {
                $errors['administrative_area'] = 'Administrative area does not belong to country';
            }
        }

        // Validate postal code if provided (null means "not provided")
        if (array_key_exists('postal_code', $attributes) && $attributes['postal_code'] !== null) {
            $countryCode = $country ? $country->code : ($attributes['country_code'] ?? null);
            $formatted = PostalCodeFormatter::format($attributes['postal_code'], $countryCode);
            if ($formatted === null) {
                $errors['postal_code'] = 'Invalid postal code for country';
            }
        }

        return $errors;
    }

    /**
     * Validate and throw InvalidArgumentException on errors.
     *
     * @param array<string,mixed> $attributes
     * @throws \InvalidArgumentException
     * @return void
     */
    public static function validateOrFail(array $attributes): void
    {
        $errors = self::validate($attributes);
        if (!empty($errors)) {
            $parts = [];
            foreach ($errors as $key => $msg) {
                $parts[] = $key . ': ' . $msg;
            }
            throw new \InvalidArgumentException(implode('; ', $parts));
        }
    }
}
