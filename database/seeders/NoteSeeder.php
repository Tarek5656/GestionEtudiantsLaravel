<?php

namespace Database\Seeders;

use App\Models\Etudiant;
use App\Models\Examen;
use App\Models\Note;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Examen::all()->each(function ($exam) {
            $etudiants = Etudiant::where('filiere_id', $exam->matiere->filiere_id)
                ->where('annee_academique_id', $exam->matiere->annee_academique_id)
                ->get();

            foreach ($etudiants as $etudiant) {
                Note::create([
                    'valeur' => rand(5, 20),
                    'etudiant_id' => $etudiant->id,
                    'examen_id' => $exam->id,
                ]);
            }
        });
    }
}
