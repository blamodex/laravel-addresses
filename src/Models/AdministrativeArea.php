<?php

declare(strict_types=1);

namespace Blamodex\Address\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * AdministrativeArea Model
 *
 * @property int $id
 * @property string $uuid
 * @property int $country_id
 * @property string $name
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Country $country
 */
class AdministrativeArea extends Model
{
    use SoftDeletes;

    protected $table = 'administrative_areas';
    protected $fillable = [
        'uuid',
        'country_id',
        'name',
        'code',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::orderedUuid()->toString();
            }
        });
    }

    /**
     * Get the country for this administrative area.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Country, AdministrativeArea>
     */
    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        /** @var \Illuminate\Database\Eloquent\Relations\BelongsTo<Country, AdministrativeArea> $relation */
        $relation = $this->belongsTo(Country::class, 'country_id');
        return $relation;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Address, AdministrativeArea>
     */
    public function addresses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        /** @var \Illuminate\Database\Eloquent\Relations\HasMany<Address, AdministrativeArea> $relation */
        $relation = $this->hasMany(Address::class, 'administrative_area_id');
        return $relation;
    }
}
