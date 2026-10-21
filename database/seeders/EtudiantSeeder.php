<?php

namespace Database\Seeders;

use App\Models\AnneeFiliere;
use App\Models\Etudiant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtudiantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $anneeFilieres = AnneeFiliere::all();

        foreach ($anneeFilieres as $anneeFiliere) {
            Etudiant::factory()->count(10)->create([
                'filiere_id' => $anneeFiliere->filiere->id,
                'annee_academique_id' => $anneeFiliere->anneeAcademique->id,
            ]);
        }
    }
}
