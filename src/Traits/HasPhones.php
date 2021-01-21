<?php

namespace Andcarpi\LaravelEnderecoETelefone\Traits;

use Andcarpi\LaravelEnderecoETelefone\Models\Phone;

trait HasPhones
{

    /**
     * Get all addresses for this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function phones(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Phone::class, 'phonable');
    }

    /**
     * Check if model has an address.
     *
     * @return bool
     */
    public function hasPhone(): bool
    {
        return (bool) $this->phones()->count();
    }

}
