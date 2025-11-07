<?php

declare(strict_types=1);

namespace Blamodex\Address\Tests\Fixtures;

use Blamodex\Address\Contracts\AddressableInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Dummy company model for testing purposes
 */
class DummyAddressCompany extends Model implements AddressableInterface
{
    protected $table = 'dummy_address_companies';
    
    protected $fillable = ['name', 'industry'];
    
    public $timestamps = true;
}
