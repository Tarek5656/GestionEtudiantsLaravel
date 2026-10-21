<?php

namespace Database\Seeders;

use App\Models\AnneeAcademique;
use App\Models\Filiere;
use App\Models\Matiere;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $ing        = Filiere::where('nom', 'Ingénierie')->first();
        $eco        = Filiere::where('nom', 'Économie')->first();

        // Année 3–4
        $info       = Filiere::where('nom', 'Informatique')->first();
        $electro    = Filiere::where('nom', 'Électronique')->first();
        $finance    = Filiere::where('nom', 'Finance')->first();
        $management = Filiere::where('nom', 'Management')->first();

        // ===== Année 5 – Spécialisations =====
        $bigdata    = Filiere::where('nom', 'Big Data')->first();
        $cyber      = Filiere::where('nom', 'Cybersécurité')->first();
        $telecom    = Filiere::where('nom', 'Télécommunications')->first();
        $embarques  = Filiere::where('nom', 'Systèmes Embarqués')->first();
        $compta     = Filiere::where('nom', 'Comptabilité')->first();
        $audit      = Filiere::where('nom', 'Audit')->first();
        $marketing  = Filiere::where('nom', 'Marketing')->first();
        $rh         = Filiere::where('nom', 'Ressources Humaines')->first();

        // ================= ANNÉE 1 =================
        $this->addMatieres($ing, 1, ['Mathématiques I', 'Physique I', 'Algorithmique', 'Introduction à l’informatique', 'Électronique de base']);
        $this->addMatieres($eco, 1, ['Microéconomie', 'Mathématiques financières', 'Introduction à la comptabilité', 'Introduction au management', 'Statistiques I']);

        // ================= ANNÉE 2 =================
        $this->addMatieres($ing, 2, ['Mathématiques II', 'Physique II', 'Électronique numérique', 'Structures de données', 'Signaux et systèmes']);
        $this->addMatieres($eco, 2, ['Macroéconomie', 'Comptabilité générale', 'Management général', 'Économie d’entreprise', 'Comptabilité de gestion']);

        // ================= ANNÉE 3 =================
        $this->addMatieres($info, 3, ['Bases de données', 'Réseaux informatiques', 'Systèmes d’exploitation', 'Développement web']);
        $this->addMatieres($electro, 3, ['Télécommunications', 'Systèmes embarqués', 'Traitement du signal', 'Réseaux mobiles']);
        $this->addMatieres($finance, 3, ['Finance d’entreprise', 'Analyse financière', 'Comptabilité analytique']);
        $this->addMatieres($management, 3, ['Management stratégique', 'Marketing stratégique', 'Gestion de projet']);

        // ================= ANNÉE 4 =================
        $this->addMatieres($info, 4, ['Génie logiciel', 'Sécurité informatique', 'Systèmes distribués', 'Administration des bases de données']);
        $this->addMatieres($electro, 4, ['Télécommunications avancées', 'Électronique industrielle', 'Réseaux avancés', 'Systèmes temps réel']);
        $this->addMatieres($finance, 4, ['Marchés financiers', 'Gestion des risques', 'Audit financier']);
        $this->addMatieres($management, 4, ['Entrepreneuriat', 'Gestion de la performance', 'Stratégie d’entreprise']);

        // ================= ANNÉE 5 (S1 uniquement) =================
        $this->addMatieres($bigdata, 5, ['Machine Learning', 'Data Mining', 'Big Data Analytics', 'Cloud Computing'], false);
        $this->addMatieres($cyber, 5, ['Sécurité des réseaux', 'Cryptographie', 'Tests d’intrusion', 'Sécurité des systèmes'], false);
        $this->addMatieres($telecom, 5, ['Réseaux 5G', 'Transmission numérique', 'Réseaux sans fil', 'Sécurité des télécoms'], false);
        $this->addMatieres($embarques, 5, ['Systèmes embarqués avancés', 'IoT', 'Microcontrôleurs', 'Sécurité embarquée'], false);
        $this->addMatieres($marketing, 5, ['Marketing digital', 'Gestion de la marque', 'Stratégie marketing', 'Analyse de marché'], false);
        $this->addMatieres($compta, 5, ['Comptabilité avancée', 'Contrôle de gestion', 'Audit interne', 'Fiscalité avancée'], false);
        $this->addMatieres($audit, 5, ['Audit opérationnel', 'Audit financier', 'Audit informatique', 'Normes IFRS'], false);
        $this->addMatieres($rh, 5, ['Gestion des talents', 'Formation et développement', 'Relations sociales', 'Stratégie RH'], false);
    }

    private function addMatieres($filiere, $niveau, $subjects)
    {
        $annee = AnneeAcademique::where('niveau', $niveau)->first();
        
        foreach ($subjects as $subject) {
            Matiere::create([
                    'nom' => $subject,
                    'coefficient' => 2,
                    'filiere_id' => $filiere->id,
                    'annee_academique_id' => $annee->id,
                ]);
            }
        }
    }
