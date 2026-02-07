<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->text('registration_message')->nullable()->after('is_active');
        $table->string('document_path')->nullable()->after('registration_message');
        // Vamos usar 'is_active' = false para indicar Pendente
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['registration_message', 'document_path']);
    });
}
};
