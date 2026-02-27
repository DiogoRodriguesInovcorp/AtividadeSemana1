<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('autores', function (Blueprint $table) {
            $table->string('Nome_autor');
            $table->string('Foto_autor');
        });
    }

    public function down(): void
    {
        Schema::table('autores', function (Blueprint $table) {
            $table->string('Nome_autor');
            $table->string('Foto_autor');
        });
    }
};
