<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncomendaItem extends Model
{
    protected $fillable = [
        'encomenda_id',
        'livro_id',
        'quantidade'
    ];

    public function encomenda()
    {
        return $this->belongsTo(Encomenda::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}
