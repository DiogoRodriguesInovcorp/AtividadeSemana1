<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('livros', function (Blueprint $table) {
            $table->string('ISBN');
            $table->string('Nome_livro');
            $table->foreignid('Editora_id')->constrained('editoras');
            $table->foreignid('Autor_id')->constrained('autores');
            $table->string('Bibliografia')->nullable();
            $table->string('Imagem_da_capa');
            $table->decimal('Preco');
        });
    }

    public function down(): void
    {
        Schema::table('livros', function (Blueprint $table) {
            $table->string('ISBN');
            $table->string('Nome_livro');
            $table->foreignid('Editora_id')->constrained('editoras');
            $table->foreignid('Autor_id')->constrained('autores');
            $table->string('Bibliografia')->nullable();
            $table->string('Imagem_da_capa');
            $table->decimal('Preco');
        });
    }
};
