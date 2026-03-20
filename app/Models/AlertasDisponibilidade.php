<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertasDisponibilidade extends Model
{
    use HasFactory;

    protected $table = 'alertas_disponibilidade';

    protected $fillable = ['user_id', 'livro_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}
