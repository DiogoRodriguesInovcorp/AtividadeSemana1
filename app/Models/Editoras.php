<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Editoras extends Model
{
    use HasFactory;

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
