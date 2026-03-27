<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encomenda extends Model
{
    protected $table = 'encomendas';

    protected $fillable = [
        'user_id',
        'total',
        'morada',
        'estado'
    ];

    // relação com user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(EncomendaItem::class);
    }
}
