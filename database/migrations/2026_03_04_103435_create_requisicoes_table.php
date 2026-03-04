<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requisicoes', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('codigo')->unique();


            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('livro_id')->constrained()->onDelete('cascade');


            $table->string('estado')->default('ativa');


            $table->date('data_requisicao');
            $table->date('data_prevista_entrega');
            $table->date('data_entrega_real')->nullable();


            $table->integer('dias_decorridos')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requisicoes');
    }
};
