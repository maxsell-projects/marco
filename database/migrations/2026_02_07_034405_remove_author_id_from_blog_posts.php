<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            // Remove a coluna que está causando erro
            if (Schema::hasColumn('blog_posts', 'author_id')) {
                // Se for chave estrangeira, dropar a FK primeiro (tente adivinhar o nome ou use array)
                // Geralmente é blog_posts_author_id_foreign
                try {
                    $table->dropForeign(['author_id']); 
                } catch (\Exception $e) {
                    // Se não tiver FK, segue o baile
                }
                $table->dropColumn('author_id');
            }
        });
    }

    public function down(): void
    {
        // Não precisamos recriar o erro
    }
};