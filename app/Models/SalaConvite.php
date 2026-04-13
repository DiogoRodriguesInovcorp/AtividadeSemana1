<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaConvite extends Model
{
    use HasFactory;

    protected $table = 'sala_convites';

    protected $fillable = [
        'sala_id',
        'user_id',
        'estado',
    ];

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
