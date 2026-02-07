<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Role: admin, dev, client
            // Usamos string e indexamos para consultas rápidas
            $table->string('role')->default('client')->after('email')->index();

            // Hierarquia: Quem é o "pai" deste usuário?
            // Se for um Cliente, o parent_id será o ID do Dev.
            // Se for um Dev criado por Admin, pode ser null ou o Admin.
            $table->foreignId('parent_id')
                  ->nullable()
                  ->after('role')
                  ->constrained('users')
                  ->nullOnDelete(); // Se o Dev for deletado, o cliente não some, fica órfão (ou mude para cascade se preferir)
            
            $table->boolean('is_active')->default(true)->after('parent_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['role', 'parent_id', 'is_active']);
        });
    }
};