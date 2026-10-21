<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnneeAcademique;
use App\Models\Bulletin;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Services\BulletinService;
use Illuminate\Http\Request;

class BulletinController extends Controller
{
    //
    public function show(Etudiant $etudiant, BulletinService $service)
    {
        $data = $service->creerBulletinPourEtudiant($etudiant);
        $matieres = $data['matieres'];
        $bulletin = $data['bulletin'];

        return view('admin.etudiants.bulletin', compact('etudiant', 'matieres', 'bulletin'));
    }

    public function anciens(
        Etudiant $etudiant,
        Request $request,
        BulletinService $service
    ) {
        // 1️⃣ années disponibles (seulement celles où il a un bulletin)
        $annees = AnneeAcademique::whereHas('bulletins', function ($q) use ($etudiant) {
            $q->where('etudiant_id', $etudiant->id)
            ->where('annee_academique_id', '!=', $etudiant->annee_academique_id);
        })
        ->orderBy('nom')
        ->get();

        // 2️⃣ année sélectionnée
        $anneeId = $request->get('annee_academique_id');

        $bulletin = null;
        $matieres = [];

        if ($anneeId) {
            $bulletin = Bulletin::where('etudiant_id', $etudiant->id)
                ->where('annee_academique_id', $anneeId)
                ->first();

            if ($bulletin) {
                $data = $service->getBulletin(
                    $etudiant,
                    $bulletin->anneeAcademique,
                    $bulletin->filiere
                );

                $matieres = $data['matieres'];
            }
        }

        return view('admin.etudiants.bulletins-anciens', compact(
            'etudiant',
            'annees',
            'anneeId',
            'bulletin',
            'matieres'
        ));
    }

}
