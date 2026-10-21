<?php

namespace Database\Seeders;

use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $etudiants = Etudiant::all();

        foreach ($etudiants as $etudiant) {
            // Génère l'email sous la forme prenom.nom@edu.isga.ma
            $email = strtolower($etudiant->prenom . '.' . $etudiant->nom . '@edu.isga.ma');

            // Crée l'utilisateur si pas déjà existant
            User::create([
                    'name' => $etudiant->nom . ' ' . $etudiant->prenom,
                    'password' => 'password',
                    'email' => $email,
                    'role' => 'user',
                    'etudiant_id' => $etudiant->id,
                ]);
            $etudiant->user_id = User::where('email', $email)->first()->id;
            $etudiant->update();
        }
    }
}
