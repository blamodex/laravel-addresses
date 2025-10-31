<?php

namespace Blamodex\Address\Tests\Fixtures;

use Blamodex\Address\Contracts\AddressableInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Dummy user model for testing purposes
 */
class DummyAddressUser extends Model implements AddressableInterface
{
    protected $table = 'dummy_address_users';
    
    protected $fillable = ['name', 'email'];
    
    public $timestamps = true;
}
