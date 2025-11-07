<?php

namespace Blamodex\Address\Tests\Fixtures;

use Blamodex\Address\Contracts\AddressableInterface;
use Blamodex\Address\Traits\Addressable;
use Illuminate\Database\Eloquent\Model;

/**
 * Dummy model that uses the Addressable trait for testing
 */
class DummyAddressableModel extends Model implements AddressableInterface
{
    use Addressable;

    protected $table = 'dummy_address_users';
    protected $fillable = ['name', 'email'];
    public $timestamps = true;
}
