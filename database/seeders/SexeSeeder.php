<?php

namespace Database\Seeders;

use App\Models\Sexe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SexeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $sexes = ['Homme', 'Femme'];
        foreach ($sexes as $sexe) {
            Sexe::create(['nom' => $sexe]);
        }
    }
}
