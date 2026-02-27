<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('editoras', function (Blueprint $table) {
            $table->string('Nome_editora');
            $table->string('Logo_editora');
        });
    }

    public function down(): void
    {
        Schema::table('editoras', function (Blueprint $table) {
            $table->string('Nome_editora');
            $table->string('Logo_editora');
        });
    }
};
