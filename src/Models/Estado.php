<?php

namespace andcarpi\LaravelEnderecoETelefone\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    public function cidades(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Cidade::class);
    }

    public function pais(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pais::class);
    }
}
