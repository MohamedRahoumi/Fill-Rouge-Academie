<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seance_id')->constrained('seances')->onDelete('cascade');
            $table->foreignId('joueur_id')->constrained('joueurs')->onDelete('cascade');
            $table->boolean('est_present')->default(false);
            $table->string('motif_absence')->nullable();
            $table->timestamps();
            $table->unique(['seance_id', 'joueur_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
