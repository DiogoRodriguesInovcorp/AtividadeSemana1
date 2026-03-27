<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarrinhoItem extends Model
{
    protected $fillable = ['carrinho_id', 'livro_id', 'quantidade'];

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}
