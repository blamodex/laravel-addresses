<?php

declare(strict_types=1);

namespace Blamodex\Address\Tests\Unit;

use Blamodex\Address\Models\AdministrativeArea;
use Blamodex\Address\Models\Country;
use Blamodex\Address\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdministrativeAreaTest extends TestCase
{
    /**
     * It returns a BelongsTo relation for country
     */
    public function test_country_relation_returns_belongs_to(): void
    {
        $area = new AdministrativeArea();

        $relation = $area->country();

        $this->assertInstanceOf(BelongsTo::class, $relation);
    }

    /**
     * It returns a HasMany relation for addresses
     */
    public function test_addresses_relation_returns_has_many(): void
    {
        $area = new AdministrativeArea();

        $relation = $area->addresses();

        $this->assertInstanceOf(HasMany::class, $relation);
    }

    /**
     * It populates uuid when creating an administrative area (booted)
     */
    public function test_booted_populates_uuid_on_create(): void
    {
        $country = Country::first();
        if (! $country) {
            $country = Country::create(['name' => 'ACountry', 'code' => 'AC']);
        }

        $area = AdministrativeArea::create([
            'country_id' => $country->id,
            'name' => 'Test Area',
            'code' => 'TA',
        ]);

        $this->assertNotEmpty($area->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $area->uuid
        );
    }
}
