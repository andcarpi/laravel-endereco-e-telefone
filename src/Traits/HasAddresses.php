<?php

namespace Andcarpi\LaravelEnderecoETelefone\Traits;

use Andcarpi\LaravelEnderecoETelefone\Models\Address;

trait HasAddresses
{

    /**
     * Get all addresses for this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Check if model has an address.
     *
     * @return bool
     */
    public function hasAddress()
    {
        return (bool) $this->addresses()->count();
    }

}
