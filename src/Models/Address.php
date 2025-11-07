<?php

declare(strict_types=1);

namespace Blamodex\Address\Models;

use Blamodex\Address\Contracts\AddressableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Address model representing an address entity.
 *
 * @property int $id
 * @property string $uuid
 * @property int $addressable_id
 * @property string $addressable_type
 * @property string $address_1
 * @property string|null $address_2
 * @property string $city
 * @property string $subnation
 * @property string $postal_code
 * @property string $country
 * @property int $administrative_area_id
 * @property int $country_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Address extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'address_1',
        'address_2',
        'city',
        'administrative_area_id',
        'postal_code',
        'country_id',
        'addressable_id',
        'addressable_type'
    ];

    /**
     * Laravel model booting hook.
     *
     * @return void
     */
    protected static function booted(): void
    {
        parent::booted();

        static::creating(function (Address $address) {
            if (empty($address->uuid)) {
                $address->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the addressable entity that owns the address.
     *
     * @phpstan-return MorphTo<Model&\Blamodex\Address\Contracts\AddressableInterface, $this>
     */
    public function addressable(): MorphTo
    {
        /** @var MorphTo<\Illuminate\Database\Eloquent\Model&\Blamodex\Address\Contracts\AddressableInterface, $this> $relation */
        $relation = $this->morphTo('addressable');

        return $relation;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Country, Address>
     */
    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        /** @var \Illuminate\Database\Eloquent\Relations\BelongsTo<Country, Address> $relation */
        $relation = $this->belongsTo(Country::class, 'country_id');
        return $relation;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<AdministrativeArea, Address>
     */
    public function administrativeArea(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        /** @var \Illuminate\Database\Eloquent\Relations\BelongsTo<AdministrativeArea, Address> $relation */
        $relation = $this->belongsTo(AdministrativeArea::class, 'administrative_area_id');
        return $relation;
    }
}
