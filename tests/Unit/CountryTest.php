<?php

declare(strict_types=1);

namespace Blamodex\Address\Tests\Unit;

use Blamodex\Address\Models\Country;
use Blamodex\Address\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CountryTest extends TestCase
{
    /**
     * It returns correct HasMany relation for addresses
     */
    public function test_addressable_relation_returns_has_many(): void
    {
        $country = new Country();

        $relation = $country->addresses();

        $this->assertInstanceOf(HasMany::class, $relation);
    }

    /**
     * It returns correct HasMany relation for administrative areas
     */
    public function test_administrative_areas_relation_returns_has_many(): void
    {
        $country = new Country();

        $relation = $country->administrativeAreas();

        $this->assertInstanceOf(HasMany::class, $relation);
    }

    /**
     * It populates uuid when creating a country (booted)
     */
    public function test_booted_populates_uuid_on_create(): void
    {
        $country = Country::create([
            'name' => 'Testland',
            'code' => 'TL',
        ]);

        $this->assertNotEmpty($country->uuid);
        // Basic UUID v4-ish pattern check
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $country->uuid
        );
    }
}
