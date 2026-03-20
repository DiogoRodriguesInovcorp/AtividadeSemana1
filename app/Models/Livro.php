<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Livro extends Model
{
    protected $attributes = [

    ];

    protected $fillable = [
        'ISBN',
        'Nome_livro',
        'Editora_id',
        'Autor_id',
        'Bibliografia',
        'disponivel',
        'Imagem_da_capa',
        'Preco'
    ];

    public function autores()
    {
        return $this->belongsToMany(Autores::class, 'autor_livro', 'livro_id', 'autor_id');
    }

    public function editoras()
    {
        return $this->belongsTo(Editoras::class, 'Editora_id');
    }

    public function requisicoes()
    {
        return $this->hasMany(Requisicao::class);
    }

    public function estaDisponivel()
    {
        return !$this->requisicoes()
            ->where('estado', 'ativa')
            ->exists();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
