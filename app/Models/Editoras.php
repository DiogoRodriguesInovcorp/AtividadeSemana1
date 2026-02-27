<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Editoras extends Model
{
    protected $guarded = [];

    protected $table = 'editoras';

    protected $attributes = [
    ];

    protected $fillable = [
        'Nome_editora',
        'Logo_editora',
    ];

    public function livros()
    {
        return $this->hasMany(Livro::class, 'Editora_id');
    }
}
