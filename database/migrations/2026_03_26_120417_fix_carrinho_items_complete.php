<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite workaround → usar SQL direto
        if (!Schema::hasColumn('carrinho_items', 'carrinho_id')) {
            DB::statement('ALTER TABLE carrinho_items ADD COLUMN carrinho_id INTEGER');
        }
        if (!Schema::hasColumn('carrinho_items', 'livro_id')) {
            DB::statement('ALTER TABLE carrinho_items ADD COLUMN livro_id INTEGER');
        }
        if (!Schema::hasColumn('carrinho_items', 'quantidade')) {
            DB::statement('ALTER TABLE carrinho_items ADD COLUMN quantidade INTEGER DEFAULT 1');
        }
    }

    public function down(): void
    {
        // SQLite não suporta drop column facilmente
    }
};
