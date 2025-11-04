<?php

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
 * @property string $administrative_area
 * @property string $administrative_area_code
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
        'administrative_area',
        'administrative_area_code',
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
     * Get the country for this administrative area.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'administrative_area_id');
    }
}
