<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnneeAcademique;
use App\Models\AnneeFiliere;
use App\Models\Bulletin;
use App\Models\Etudiant;
use App\Models\Matiere;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        $anneeId = $request->get('annee_academique_id');

        // 📌 Étudiants filtrés par année
        $etudiants = Etudiant::with(['bulletins'])
            ->when($anneeId, fn($q) => $q->where('annee_academique_id', $anneeId))
            ->get();

        $totalEtudiants = $etudiants->count();

        // Nombre d'étudiants validés/non validés
        $valides = $etudiants->filter(fn($e) => $e->bulletin_courant?->valider)->count();
        $nonValides = $totalEtudiants - $valides;

        // Moyenne globale
       $moyenneGlobale = round(
            $etudiants
                ->map(fn($e) => $e->bulletin_courant?->moyenne_generale)
                ->avg(),
            2
        );

        // 📊 Taux de réussite par filière
        $anneeFilieres = AnneeFiliere::with(['filiere.etudiants.bulletins'])
            ->when($anneeId, fn($q) => $q->where('annee_academique_id', $anneeId))
            ->get();

        $statsFilieres = $anneeFilieres->map(function ($af) {

            $etudiants = Etudiant::where('filiere_id', $af->filiere_id)
                ->where('annee_academique_id', $af->annee_academique_id)
                ->with('bulletins')
                ->get();

            if ($etudiants->isEmpty()) return null;

            $total = $etudiants->count();
            $valides = $etudiants->filter(
                fn($e) => $e->bulletin_courant?->valider
            )->count();

            return [
                'nom' => $af->filiere->nom . ' (' . $af->anneeAcademique->nom . ')',
                'taux' => round(($valides * 100) / $total, 1),
            ];
        })->filter();
        // enlève les filières sans étudiants

        // 📊 Taux de réussite par sexe
        $etudiants = Etudiant::with('sexe', 'bulletins')
            ->when($anneeId, fn($q) => $q->where('annee_academique_id', $anneeId))
            ->get();

        $statsSexes = $etudiants->groupBy(fn($e) => $e->sexe?->nom ?? 'Inconnu')
            ->map(function ($group, $sexe) {
                $total = $group->count();
                $valides = $group->filter(fn($e) => $e->bulletin_courant?->valider)->count();
                $taux = $total > 0 ? ($valides * 100 / $total) : 0;

                return [
                    'sexe' => $sexe,
                    'total' => $total,
                    'valides' => $valides,
                    'taux' => round($taux, 1)
                ];
            });

        // 📉 Matières difficiles (moyenne < 10)
        $matieresDifficiles = Matiere::whereHas('moyennesMatieres')
            ->when($anneeId, fn($q) => $q->where('annee_academique_id', $anneeId))
            ->with('moyennesMatieres')
            ->get()
            ->map(function ($m) {
                $notes = $m->moyennesMatieres;

                if ($notes->isEmpty()) return null;

                return [
                    'nom' => $m->nom,
                    'moyenne' => round($notes->avg('moyenne'), 2)
                ];
            })
            ->filter(fn($m) => $m && $m['moyenne'] < 10)
            ->sortBy('moyenne')
            ->take(5);

        $annees = AnneeAcademique::all();

        return view('admin.dashboard', compact(
            'totalEtudiants',
            'valides',
            'nonValides',
            'moyenneGlobale',
            'statsFilieres',
            'matieresDifficiles',
            'annees',
            'statsSexes'
        ));
    }
}

