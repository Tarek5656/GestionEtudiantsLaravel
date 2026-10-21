<?php

namespace Database\Seeders;

use App\Models\AnneeAcademique;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnneeAcademiqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i = 1; $i <= 5; $i++) {
            AnneeAcademique::create([
                'nom' => $i === 1 ? "{$i}ère Année" : "{$i}ème Année",
                'niveau' => $i
            ]);
        }
    }
}
