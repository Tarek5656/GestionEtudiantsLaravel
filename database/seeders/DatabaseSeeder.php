<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
        $this->call([
        AnneeAcademiqueSeeder::class,
        FiliereSeeder::class,
        MatiereSeeder::class,
        SexeSeeder::class,
        EtudiantSeeder::class,
        UserSeeder::class,
        TypeExamenSeeder::class,
        ExamenSeeder::class,
        NoteSeeder::class,
        BulletinSeeder::class,
    ]);
    }
}
