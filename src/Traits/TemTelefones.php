<?php

namespace andcarpi\LaravelEnderecoETelefone\Traits;

use andcarpi\LaravelEnderecoETelefone\Models\Telefone;

trait TemTelefones
{
    /**
     * Get all phones for this model.
     */
    public function telefones(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Telefone::class, 'phonable');
    }

    /**
     * Get the phone for this model.
     */
    public function telefone(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Telefone::class, 'phonable');
    }

    /**
     * Check if model has a phone.
     */
    public function temTelefones(): bool
    {
        return (bool) $this->telefones()->count();
    }
}
