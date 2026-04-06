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
    public function up(): void {
        if (!Schema::hasColumn('carrinhos', 'user_id')) {
            DB::statement('ALTER TABLE carrinhos ADD COLUMN user_id INTEGER');
        }
    }

    public function down(): void
    {
        // SQLite não suporta drop column facilmente
    }
};
