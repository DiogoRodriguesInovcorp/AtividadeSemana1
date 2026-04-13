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
        'role',
        'foto_user'
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
        return $this->role === 'bibliotecario';
    }

    public function autores()
    {
        return $this->hasMany(Autores::class);
    }

    public function editoras()
    {
        return $this->hasMany(Editoras::class);
    }

    public function requisicoes()
    {
        return $this->hasMany(Requisicao::class);
    }

    public function requisicoesAtivas()
    {
        return $this->requisicoes()
            ->where('estado', 'ativa');
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function encomendas()
    {
        return $this->hasMany(Encomenda::class);
    }

    public function carrinho()
    {
        return $this->hasOne(Carrinho::class);
    }

    public function salas()
    {
        return $this->belongsToMany(Sala::class);
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

