<?php

declare(strict_types=1);

namespace Blamodex\Address\Tests\Unit;

use Blamodex\Address\Validators\AddressValidator;
use Blamodex\Address\Tests\TestCase;

class AddressValidatorTest extends TestCase
{
    public function test_valid_us_address_returns_no_errors(): void
    {
        $attributes = [
            'country_code' => 'US',
            'administrative_area_code' => 'CA',
            'postal_code' => '90001',
        ];

        $errors = AddressValidator::validate($attributes);

        $this->assertIsArray($errors);
        $this->assertEmpty($errors);

        // validateOrFail should not throw
        AddressValidator::validateOrFail($attributes);
        $this->addToAssertionCount(1); // mark that validateOrFail ran
    }

    public function test_invalid_country_code_returns_error(): void
    {
        $errors = AddressValidator::validate(['country_code' => 'ZZ']);
        $this->assertArrayHasKey('country_code', $errors);
    }

    public function test_unknown_country_name_returns_error(): void
    {
        $errors = AddressValidator::validate(['country_name' => 'Atlantis']);
        $this->assertArrayHasKey('country_name', $errors);
    }

    public function test_invalid_administrative_area_code_returns_error(): void
    {
        $errors = AddressValidator::validate(['country_code' => 'US', 'administrative_area_code' => 'XX']);
        $this->assertArrayHasKey('administrative_area_code', $errors);
    }

    public function test_mismatched_administrative_area_and_country_returns_error(): void
    {
        // 'CA' admin code exists for US (California) but here we claim country_code 'CA' (Canada)
        $errors = AddressValidator::validate(['country_code' => 'CA', 'administrative_area_code' => 'CA']);
        $this->assertArrayHasKey('administrative_area', $errors);
    }

    public function test_invalid_postal_code_returns_error(): void
    {
        $errors = AddressValidator::validate(['country_code' => 'US', 'postal_code' => 'BAD']);
        $this->assertArrayHasKey('postal_code', $errors);
    }

    public function test_null_postal_code_is_ignored(): void
    {
        $errors = AddressValidator::validate(['country_code' => 'US', 'postal_code' => null]);
        // postal_code present but null should be ignored
        $this->assertArrayNotHasKey('postal_code', $errors);
        $this->assertEmpty($errors);
    }

    public function test_validateOrFail_throws_on_errors(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        AddressValidator::validateOrFail(['country_code' => 'ZZ', 'postal_code' => 'BAD']);
    }
}
