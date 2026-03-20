<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisicao extends Model
{

    protected $table = 'requisicoes';

    protected $fillable = [
        'codigo',
        'user_id',
        'livro_id',
        'estado',
        'data_requisicao',
        'data_prevista_entrega',
        'data_entrega_real',
        'dias_decorridos'
    ];

    protected $dates = [
        'data_requisicao',
        'data_prevista_entrega',
        'data_entrega_real'
    ];

    protected $casts = [
        'data_requisicao' => 'datetime',
        'data_prevista_entrega' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function livros()
    {
        return $this->belongsTo(Livro::class, 'livro_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
