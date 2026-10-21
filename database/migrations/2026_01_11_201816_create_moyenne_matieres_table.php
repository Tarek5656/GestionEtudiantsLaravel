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
        Schema::create('moyenne_matieres', function (Blueprint $table) {
            $table->id();
            $table->float('moyenne');
            $table->foreignId('matiere_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('etudiant_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moyenne_matieres');
    }
};
