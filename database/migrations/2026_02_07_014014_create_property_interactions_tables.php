<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabela Pivô: Acesso Concedido
        // Guarda quais imóveis PRIVADOS ou OFF-MARKET um cliente específico pode ver
        Schema::create('property_user_access', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // O Cliente
            
            // Quem liberou o acesso? (Geralmente o Dev desse cliente)
            $table->foreignId('granted_by')->constrained('users'); 
            
            $table->timestamps();

            // Regra: Um cliente só pode ter uma permissão por imóvel
            $table->unique(['property_id', 'user_id']);
        });

        // 2. Tabela de Favoritos
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'property_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('property_user_access');
    }
};