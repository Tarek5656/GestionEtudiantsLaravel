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
        Schema::create('bulletins', function (Blueprint $table) {
            $table->id();
            $table->float('moyenne_generale');
            $table->boolean('valider')->default(false);
            $table->foreignId('etudiant_id')->
            references('id')->
            on('etudiants')->
            onDelete('cascade');
            $table->foreignId('filiere_id')->
            references('id')->
            on('filieres')->
            onDelete('cascade');
            $table->foreignId('annee_academique_id')->
            references('id')->
            on('annee_academiques')->
            onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulletins');
    }
};
