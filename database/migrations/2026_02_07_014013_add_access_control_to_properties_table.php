<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // 1. User ID (Dono do imóvel)
            if (!Schema::hasColumn('properties', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->cascadeOnDelete();
            }

            // 2. Status (Workflow)
            if (!Schema::hasColumn('properties', 'status')) {
                $table->string('status')->default('draft')->after('user_id')->index();
            }

            // 3. Visibilidade (Public, Off-market, Private)
            if (!Schema::hasColumn('properties', 'visibility')) {
                // Tenta colocar após 'status', se não der, põe no final
                $after = Schema::hasColumn('properties', 'status') ? 'status' : 'user_id';
                $table->string('visibility')->default('public')->after($after)->index();
            }
            
            // 4. Aprovação
            if (!Schema::hasColumn('properties', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Removemos apenas se existirem (boa prática no down também)
            if (Schema::hasColumn('properties', 'approved_at')) {
                $table->dropColumn('approved_at');
            }
            if (Schema::hasColumn('properties', 'visibility')) {
                $table->dropColumn('visibility');
            }
            // Não removemos status e user_id se eles já existiam antes dessa migration
            // Para ser seguro, removemos apenas se tivermos certeza, 
            // mas num rollback de dev, geralmente queremos limpar tudo:
            $table->dropColumn(['status']);
            // $table->dropForeign(['user_id']); // Cuidado com chaves estrangeiras
            // $table->dropColumn(['user_id']);
        });
    }
};