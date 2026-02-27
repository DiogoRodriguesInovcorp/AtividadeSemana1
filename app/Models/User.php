<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'Preco',
        'Bibliografia',
        'Autor',
        'Editora',
        'Nome_livro',
        'ISBN',
        'Nome_autor',
        'Foto_autor',
        'Nome_editora',
        'Logo_editora',
        'Editora_id',
        'Autor_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function livros()
    {
        return $this->hasMany(Livro::class);
    }

    public function isAdmin(): bool
    {
        return $this->id === 1;
    }

    public function autores()
    {
        return $this->hasMany(Autores::class);
    }

    public function editoras()
    {
        return $this->hasMany(Editoras::class);
    }
}

