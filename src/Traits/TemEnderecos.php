<?php

namespace andcarpi\LaravelEnderecoETelefone\Traits;

use andcarpi\LaravelEnderecoETelefone\Models\Endereco;

trait TemEnderecos
{

    /**
     * Get all addresses for this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function enderecos()
    {
        return $this->morphMany(Endereco::class, 'addressable');
    }

    /**
     * Check if model has an address.
     *
     * @return bool
     */
    public function temEnderecos(): bool
    {
        return (bool) $this->enderecos()->count();
    }

}
