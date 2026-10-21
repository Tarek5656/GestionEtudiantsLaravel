<?php

namespace Database\Seeders;

use App\Models\TypeExamen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeExamenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $types = ['Contrôle Continu', 'Examen Final'];
        foreach ($types as $type) {
            TypeExamen::create(['nom' => $type]);
        }

    }
}
