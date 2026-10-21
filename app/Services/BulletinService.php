<?php

namespace App\Services;

use App\Models\AnneeAcademique;
use App\Models\Bulletin;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\MoyenneMatiere;
use App\Models\Validation;

class BulletinService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function creerBulletinPourEtudiant(Etudiant $etudiant): array
    {
        $etudiant->load([
            'filiere',
            'anneeAcademique',
            'notes.examen.typeExamen',
            'moyennesMatieres.validation'
        ]);

        $matieres = [];
        $totalCoef = 0;
        $totalGeneral = 0;

        // Récupérer toutes les matières de la filière et année de l'étudiant
        $allMatieres = Matiere::where('filiere_id', $etudiant->filiere_id)
            ->where('annee_academique_id', $etudiant->annee_academique_id)
            ->get();

        foreach ($allMatieres as $matiere) {
            // Initialiser la ligne matière
            $matieres[$matiere->id] = [
                'nom' => $matiere->nom,
                'coef' => $matiere->coefficient ?? 1, // si pas de coefficient, mettre 1 par défaut
                'cc' => null,
                'final' => null,
                'valide' => false,
            ];

            // Récupérer les notes de l'étudiant pour cette matière
            $notes = $etudiant->notes->whereIn('examen_id', $matiere->examens->pluck('id'));

            foreach ($notes as $note) {
                $type = $note->examen->typeExamen->nom;
                if ($type === 'Contrôle Continu') {
                    $matieres[$matiere->id]['cc'] = $note->valeur;
                } elseif ($type === 'Examen Final') {
                    $matieres[$matiere->id]['final'] = $note->valeur;
                }
            }

            // Calcul de la moyenne matière
            $cc = $matieres[$matiere->id]['cc'] ?? 0;
            $final = $matieres[$matiere->id]['final'] ?? 0;
            $moyenne = round(($cc + $final) / 2, 2);
            $matieres[$matiere->id]['moyenne'] = $moyenne;

            // Validation de la matière
            $valide = $matieres[$matiere->id]['final'] !== null
            && $final >= 7
            && $moyenne >= 10;
            $matieres[$matiere->id]['valide'] = $valide;

            // Calculs des coefficients totaux pour la moyenne générale
            $totalCoef += $matieres[$matiere->id]['coef'];
            $totalGeneral += $moyenne * $matieres[$matiere->id]['coef'];

            // Sauvegarder la moyenne matière
            $moyenneMatiere = MoyenneMatiere::updateOrCreate(
                ['etudiant_id' => $etudiant->id, 'matiere_id' => $matiere->id],
                ['moyenne' => $moyenne]
            );

            Validation::updateOrCreate(
                ['moyenne_matiere_id' => $moyenneMatiere->id],
                ['valide' => $valide]
            );
        }

        // Moyenne générale pondérée
        $moyenneGenerale = $totalCoef > 0 ? round($totalGeneral / $totalCoef, 2) : 0;

        //valider le bulletin si toutes les matières sont validées
        $bulletinValide = $etudiant->moyennesMatieres()->count() > 0
        && $etudiant->moyennesMatieres()->whereHas('validation', function ($q) {
            $q->where('valide', false);
        })->count() === 0;

        // Sauvegarder bulletin
        $bulletin = Bulletin::updateOrCreate(
                    ['etudiant_id' => $etudiant->id,
                    'filiere_id' => $etudiant->filiere_id,
                    'annee_academique_id' => $etudiant->annee_academique_id],
                    ['moyenne_generale' => $moyenneGenerale, 
                    'valider' => $bulletinValide]
                    );

        return [
            'matieres' => $matieres,
            'bulletin' => $bulletin,
        ];
    }

    public function getBulletin(Etudiant $etudiant, AnneeAcademique $anneeAcademique, Filiere $filiere)
    {
        $etudiant->load([
            'notes.examen.typeExamen',
            'moyennesMatieres.validation'
        ]);

        $matieres = [];

        // Récupérer toutes les matières de la filière et année de l'étudiant
        $allMatieres = Matiere::where('filiere_id', $filiere->id)
            ->where('annee_academique_id', $anneeAcademique->id)
            ->with('examens')
            ->get();

        foreach ($allMatieres as $matiere) {
            // Initialiser la ligne matière
            $matieres[$matiere->id] = [
                'nom' => $matiere->nom,
                'coef' => $matiere->coefficient ?? 1, // si pas de coefficient, mettre 1 par défaut
                'cc' => null,
                'final' => null,
                'moyenne' => null,
                'valide' => false,
            ];

            // Récupérer les notes de l'étudiant pour cette matière
            $notes = $etudiant->notes->whereIn('examen_id', $matiere->examens->pluck('id'));

            foreach ($notes as $note) {
                $type = $note->examen->typeExamen->nom;
                if ($type === 'Contrôle Continu') {
                    $matieres[$matiere->id]['cc'] = $note->valeur;
                } elseif ($type === 'Examen Final') {
                    $matieres[$matiere->id]['final'] = $note->valeur;
                }
            }

            $moyenne = $etudiant->moyennesMatieres
                ->where('matiere_id', $matiere->id)
                ->first();
            $matieres[$matiere->id]['moyenne'] = $moyenne->moyenne;
            $matieres[$matiere->id]['valide'] = $moyenne?->validation?->valide ?? false;
        }

        $bulletin = Bulletin::where('annee_academique_id', $anneeAcademique->id)
                                ->where('filiere_id', $filiere->id)->get();

        return [
            'matieres' => $matieres,
            'bulletin' => $bulletin,
        ];
    }
}
