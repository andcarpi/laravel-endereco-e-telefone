<?php

namespace andcarpi\LaravelEnderecoETelefone\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    protected $table = 'paises';

    public function estados(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Estado::class);
    }
}
