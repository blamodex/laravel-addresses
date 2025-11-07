<?php

declare(strict_types=1);

namespace Blamodex\Address\Utils;

class PostalCodeFormatter
{
    /**
     * Format a postal code for a given country.
     *
     * Public contract:
     * - Accepts string|null for $postalCode and string|null for $countryCode.
     * - If $postalCode is null or $countryCode is explicitly null, returns null.
     * - On success returns a normalized string. On invalid/unsupported input returns null.
     *
     * @param string|null $postalCode
     * @param string|null $countryCode
     * @return string|null Normalized postal code or null when invalid/unsupported
     */
    public static function format(?string $postalCode, ?string $countryCode = 'CA'): ?string
    {
        if ($postalCode === null) {
            return null;
        }

        // Explicit null country code means "no formatting/unknown"
        if ($countryCode === null) {
            return null;
        }

        $postalCode = trim($postalCode);

        if ($countryCode === 'US') {
            // Accept input like 12345-6789 first (preserve dash)
            if (preg_match('/^(\d{5})-(\d{4})$/', $postalCode, $matches)) {
                return $matches[1] . '-' . $matches[2];
            }

            // Normalize: remove non-digits
            $normalized = preg_replace('/[^\d]/', '', $postalCode);

            // ZIP+4: 123456789 (normalized)
            if ($normalized !== null && preg_match('/^(\d{5})(\d{4})$/', $normalized, $matches)) {
                return $matches[1] . '-' . $matches[2];
            }

            // 5-digit ZIP
            if ($normalized !== null && preg_match('/^\d{5}$/', $normalized)) {
                return $normalized;
            }
        } elseif ($countryCode === 'CA') {
            // Normalize: remove spaces, uppercase
            $normalized = strtoupper(str_replace(' ', '', $postalCode));
            // Canadian postal code: A1A1A1 or A1A 1A1
            if (preg_match('/^([A-Z]\d[A-Z])(\d[A-Z]\d)$/', $normalized, $matches)) {
                return $matches[1]  . ' ' . $matches[2];
            }
        }

        return null;
    }
}
