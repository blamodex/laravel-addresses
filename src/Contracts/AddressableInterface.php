<?php

namespace Blamodex\Address\Contracts;

/**
 * Interface AddressableInterface
 *
 */
interface AddressableInterface
{
    /**
     * Get the unique identifier for the model.
     *
     * Typically the primary key.
     *
     * @return mixed
     */
    public function getKey();

    /**
     * Get the morph class name for the model.
     *
     * Used in polymorphic relationships.
     *
     * @return string
     */
    public function getMorphClass();
}
