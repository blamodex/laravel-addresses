<?php

namespace Blamodex\Address\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Country Model
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|AdministrativeArea[] $administrativeAreas
 */
class Country extends Model
{
    use SoftDeletes;

    protected $table = 'countries';
    protected $fillable = [
        'uuid',
        'name',
        'code',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

    /**
     * Get the administrative areas for the country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<AdministrativeArea, Country>
     */
    public function administrativeAreas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        /** @var \Illuminate\Database\Eloquent\Relations\HasMany<AdministrativeArea, Country> $relation */
        $relation = $this->hasMany(AdministrativeArea::class, 'country_id');
        return $relation;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Address, Country>
     */
    public function addresses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        /** @var \Illuminate\Database\Eloquent\Relations\HasMany<Address, Country> $relation */
        $relation = $this->hasMany(Address::class, 'country_id');
        return $relation;
    }
}
