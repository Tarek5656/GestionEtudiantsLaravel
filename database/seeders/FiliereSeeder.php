<?php

namespace Database\Seeders;

use App\Models\AnneeAcademique;
use App\Models\Filiere;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FiliereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $a1 = AnneeAcademique::where('niveau', 1)->first();
        $a2 = AnneeAcademique::where('niveau', 2)->first();
        $a3 = AnneeAcademique::where('niveau', 3)->first();
        $a4 = AnneeAcademique::where('niveau', 4)->first();
        $a5 = AnneeAcademique::where('niveau', 5)->first();

        // Tronc commun
        $ingenierie = Filiere::create(['nom' => 'Ingénierie']);
        $economie   = Filiere::create(['nom' => 'Économie']);

        $ingenierie->annees()->attach([$a1->id, $a2->id]);
        $economie->annees()->attach([$a1->id, $a2->id]);

        // Année 3–4
        $info = Filiere::create([
            'nom' => 'Informatique',
            'parent_id' => $ingenierie->id
        ]);

        $electro = Filiere::create([
            'nom' => 'Électronique',
            'parent_id' => $ingenierie->id
        ]);

        $management = Filiere::create([
            'nom' => 'Management',
            'parent_id' => $economie->id
        ]);

        $finance = Filiere::create([
            'nom' => 'Finance',
            'parent_id' => $economie->id
        ]);

        $info->annees()->attach([$a3->id, $a4->id]);
        $electro->annees()->attach([$a3->id, $a4->id]);
        $management->annees()->attach([$a3->id, $a4->id]);
        $finance->annees()->attach([$a3->id, $a4->id]);

        // ===== Année 5 – Spécialisations =====

        // Informatique (2+)
        $bigdata = Filiere::create(['nom' => 'Big Data', 'parent_id' => $info->id]);
        $cybersec = Filiere::create(['nom' => 'Cybersécurité', 'parent_id' => $info->id]);

        // Électronique (2)
        $tele = Filiere::create(['nom' => 'Télécommunications', 'parent_id' => $electro->id]);
        $sysemb = Filiere::create(['nom' => 'Systèmes Embarqués', 'parent_id' => $electro->id]);

        // Finance (2)
        $compta = Filiere::create(['nom' => 'Comptabilité', 'parent_id' => $finance->id]);
        $audit = Filiere::create(['nom' => 'Audit', 'parent_id' => $finance->id]);
        // Management (2)
        $marketing = Filiere::create(['nom' => 'Marketing', 'parent_id' => $management->id]);
        $rh = Filiere::create(['nom' => 'Ressources Humaines', 'parent_id' => $management->id]);

        $bigdata->annees()->attach($a5->id);
        $cybersec->annees()->attach($a5->id);
        $tele->annees()->attach($a5->id);
        $sysemb->annees()->attach($a5->id);
        $compta->annees()->attach($a5->id);
        $audit->annees()->attach($a5->id);
        $marketing->annees()->attach($a5->id);
        $rh->annees()->attach($a5->id);
    }
}
