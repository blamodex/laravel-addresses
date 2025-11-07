<?php

declare(strict_types=1);

namespace Blamodex\Address\Tests\Unit;

use Blamodex\Address\Utils\PostalCodeFormatter;
use PHPUnit\Framework\TestCase;

class PostalCodeFormatterTest extends TestCase
{
    public function test_formats_us_zip_code_5_digit()
    {
        $this->assertSame('12345', PostalCodeFormatter::format('12345', 'US'));
        $this->assertSame('12345', PostalCodeFormatter::format('12345 ', 'US'));
        $this->assertSame('12345', PostalCodeFormatter::format(' 12345', 'US'));
    }

    public function test_formats_us_zip_code_zip_plus_4()
    {
        $this->assertSame('12345-6789', PostalCodeFormatter::format('123456789', 'US'));
        $this->assertSame('12345-6789', PostalCodeFormatter::format('12345-6789', 'US'));
        $this->assertSame('12345-6789', PostalCodeFormatter::format('12345 6789', 'US'));
    }

    public function test_accepts_us_zip_with_dash()
    {
        // Accept input like 12345-6789 and return normalized ZIP+4
        $this->assertSame('12345-6789', PostalCodeFormatter::format('12345-6789', 'US'));
        $this->assertSame('12345-6789', PostalCodeFormatter::format('12345 - 6789', 'US'));
        $this->assertSame('12345-6789', PostalCodeFormatter::format('12345-6789 ', 'US'));
    }

    public function test_invalid_us_zip_code_returns_false()
    {
        $this->assertNull(PostalCodeFormatter::format('1234', 'US'));
        $this->assertNull(PostalCodeFormatter::format('ABCDE', 'US'));
        $this->assertNull(PostalCodeFormatter::format('123456', 'US'));
    }

    public function test_formats_ca_postal_code()
    {
        $this->assertSame('K1A 0B1', PostalCodeFormatter::format('K1A0B1', 'CA'));
        $this->assertSame('K1A 0B1', PostalCodeFormatter::format('K1A 0B1', 'CA'));
        $this->assertSame('K1A 0B1', PostalCodeFormatter::format('k1a0b1', 'CA'));
        $this->assertSame('K1A 0B1', PostalCodeFormatter::format('k1a 0b1', 'CA'));
    }

    public function test_invalid_ca_postal_code_returns_false()
    {
        $this->assertNull(PostalCodeFormatter::format('123456', 'CA'));
        $this->assertNull(PostalCodeFormatter::format('A1A1A', 'CA'));
        $this->assertNull(PostalCodeFormatter::format('ZZZ ZZZ', 'CA'));
    }

    public function test_default_country_is_ca()
    {
        $this->assertSame('K1A 0B1', PostalCodeFormatter::format('K1A0B1'));
        $this->assertNull(PostalCodeFormatter::format('123456'));
    }

    public function test_null_or_unknown_country_returns_false()
    {
        // Explicit null should not default to CA (signature allows null)
        $this->assertNull(PostalCodeFormatter::format('K1A0B1', null));

        // Unknown country codes should return null
        $this->assertNull(PostalCodeFormatter::format('12345', 'GB'));
        $this->assertNull(PostalCodeFormatter::format('K1A0B1', 'ZZ'));
    }

    public function test_null_postal_code_returns_null()
    {
        // Null postal code should always return null regardless of country
        $this->assertNull(PostalCodeFormatter::format(null, 'CA'));
        $this->assertNull(PostalCodeFormatter::format(null, 'US'));
        // Default country parameter
        $this->assertNull(PostalCodeFormatter::format(null));
        // Explicit null country
        $this->assertNull(PostalCodeFormatter::format(null, null));
    }
}
