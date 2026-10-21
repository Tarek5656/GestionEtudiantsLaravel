<?php

namespace Database\Seeders;

use App\Models\Examen;
use App\Models\Matiere;
use App\Models\TypeExamen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Matiere::all()->each(function ($matiere) {
            TypeExamen::all()->each(function ($typeExamen) use ($matiere) {

            // Définir la date selon le type d'examen
            if ($typeExamen->nom === 'Contrôle Continu') {
                $date = now()->addDays(rand(1, 30));
            } else {
                $date = now()->addDays(rand(31, 60));
            }

            Examen::create([
                'type_examen_id' => $typeExamen->id,
                'date_examen'    => $date,
                'matiere_id'     => $matiere->id,
                ]);
            });
        });
            
    }
}
