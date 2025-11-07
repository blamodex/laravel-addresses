<?php

namespace Blamodex\Address\Utils;

class PostalCodeFormatter
{
    public static function format(
        string $postalCode,
        string|null $countryCode = 'CA'
    ): string|false {
        $postalCode = trim($postalCode);

        if ($countryCode === 'US') {
            // Accept input like 12345-6789 first (preserve dash)
            if (preg_match('/^(\d{5})-(\d{4})$/', $postalCode, $matches)) {
                return $matches[1] . '-' . $matches[2];
            }
            // Normalize: remove spaces and dashes
            $normalized = preg_replace('/[^\d]/', '', $postalCode);
            // ZIP+4: 123456789 (normalized)
            if (preg_match('/^(\d{5})(\d{4})$/', $normalized, $matches)) {
                return $matches[1] . '-' . $matches[2];
            }
            // 5-digit ZIP
            if (preg_match('/^\d{5}$/', $normalized)) {
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

        return false;
    }
}
