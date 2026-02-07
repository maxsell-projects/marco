<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Adicionando os campos que o seu formulário e model exigem
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('users', 'notes')) {
                $table->text('notes')->nullable()->after('is_active');
            }
            
            if (!Schema::hasColumn('users', 'document_path')) {
                $table->string('document_path')->nullable()->after('notes');
            }
            
            if (!Schema::hasColumn('users', 'registration_message')) {
                $table->text('registration_message')->nullable()->after('document_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'notes', 'document_path', 'registration_message']);
        });
    }
};