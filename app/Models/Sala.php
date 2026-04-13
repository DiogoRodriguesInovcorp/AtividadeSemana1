<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{

    protected $fillable = [
        'nome',
        'avatar'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class);
    }

    public function convites()
    {
        return $this->hasMany(SalaConvite::class);
    }
}
