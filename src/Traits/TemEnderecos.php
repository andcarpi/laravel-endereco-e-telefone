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
        return $this->morphMany(Endereco::class, 'proprietario');
    }

    /**
     * Get the address for this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function endereco()
    {
        return $this->morphOne(Endereco::class, 'proprietario');
    }

    /**
     * Check if model has an address.
     */
    public function temEnderecos(): bool
    {
        return (bool) $this->enderecos()->count();
    }
}
