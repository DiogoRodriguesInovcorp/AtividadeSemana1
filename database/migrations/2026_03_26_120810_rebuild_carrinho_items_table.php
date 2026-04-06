<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Criar tabela nova correta
        Schema::create('carrinho_items_new', function (Blueprint $table) {
            if (!Schema::hasColumn('carrinho_items_new', 'carrinho_id','livro_id','quantidade')) {
                $table->id();
                $table->unsignedBigInteger('carrinho_id');
                $table->unsignedBigInteger('livro_id');
                $table->integer('quantidade')->default(1);
                $table->timestamps();
            }
        });

        // 2. Copiar dados antigos (se existirem)
        DB::statement('INSERT INTO carrinho_items_new (id, created_at, updated_at)
                       SELECT id, created_at, updated_at FROM carrinho_items');

        // 3. Apagar tabela antiga
        Schema::drop('carrinho_items');

        // 4. Renomear nova tabela
        Schema::rename('carrinho_items_new', 'carrinho_items');
    }

    public function down(): void
    {
        //
    }
};
