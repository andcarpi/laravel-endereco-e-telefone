<?php

namespace Andcarpi\LaravelEnderecoETelefone\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    public function cities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(City::class);
    }

    public function cidades(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->cities();
    }

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function pais(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->country();
    }
}
