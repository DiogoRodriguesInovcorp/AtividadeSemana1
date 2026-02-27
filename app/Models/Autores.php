<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Autores extends Model
{
    protected $guarded = [];

    protected $table = 'autores';

    protected $attributes = [
    ];

    protected $fillable = [
        'Nome_autor',
        'Foto_autor',
    ];

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'autor_livro', 'autor_id', 'livro_id');
    }
}
