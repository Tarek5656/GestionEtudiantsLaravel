<?php

namespace Database\Seeders;

use App\Models\Etudiant;
use App\Services\BulletinService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BulletinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $service = new BulletinService();

        Etudiant::all()->each(function ($etudiant) use ($service) {
            $service->creerBulletinPourEtudiant($etudiant);
        });
    }
}
