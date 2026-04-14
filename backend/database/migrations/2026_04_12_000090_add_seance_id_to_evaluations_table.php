<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->foreignId('seance_id')
                ->nullable()
                ->after('coach_id')
                ->constrained('seances')
                ->nullOnDelete();

            $table->unique(['seance_id', 'joueur_id']);
        });
    }

    public function down(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropUnique(['seance_id', 'joueur_id']);
            $table->dropConstrainedForeignId('seance_id');
        });
    }
};
