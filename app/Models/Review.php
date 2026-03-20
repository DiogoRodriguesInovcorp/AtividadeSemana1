<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'user_id',
        'livro_id',
        'requisicao_id',
        'comentario',
        'estado',
        'justificacao',
        'rating',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function livro(){
        return $this->belongsTo(Livro::class);
    }

    public function requisicao()
    {
        return $this->belongsTo(Requisicao::class);
    }
}
