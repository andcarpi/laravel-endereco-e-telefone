<?php

namespace andcarpi\LaravelEnderecoETelefone\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function fromCEP($cep)
    {
    }

    public function proprietario()
    {
        return $this->morphTo();
    }

    public function cidade(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cidade::class);
    }
}
