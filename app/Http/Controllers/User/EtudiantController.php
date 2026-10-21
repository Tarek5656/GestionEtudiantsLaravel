<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AnneeAcademique;
use App\Models\Bulletin;
use App\Models\Etudiant;
use App\Models\Examen;
use App\Models\Matiere;
use App\Models\TypeExamen;
use App\Services\BulletinService;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    //
    public function profile(Etudiant $etudiant)
    {
        return view('user.profile',compact('etudiant'));
    }

    public function bulletin(Etudiant $etudiant, BulletinService $service)
    {
        $bulletin =$etudiant->bulletinCourant;
        $data = $service->creerBulletinPourEtudiant($etudiant); 
        $matieres = $data['matieres'];
        $bulletin = $data['bulletin'];

        return view('user.bulletin',compact('etudiant', 'matieres', 'bulletin'));
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

        return view('user.bulletins-anciens', compact(
            'etudiant',
            'annees',
            'anneeId',
            'bulletin',
            'matieres'
        ));
    }

    public function matieres(Etudiant $etudiant, Request $request)
    {
        $query = Matiere::where('filiere_id', $etudiant->filiere_id)
                        ->where('annee_academique_id', $etudiant->annee_academique_id);

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }
        if ($request->filled('coefficient')) {
            $query->where('coefficient', 'like', '%' . $request->coefficient . '%');
        }

        $sortBy  = $request->get('sort_by', 'id');
        $sortDir = $request->get('sort_dir', 'asc');

        $allowedSorts = ['id', 'nom' ,'coef'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }

        $query->select('matieres.*'); // OBLIGATOIRE

        switch ($sortBy) {

            case 'id':
                $query->orderBy('id',$sortDir);
                break;

            case 'nom':
                $query->orderBy('nom', $sortDir);
                break;

            case 'coef':
                $query->orderBy('coefficient', $sortDir);
                break;

            default:
                $query->orderBy('matieres.' . $sortBy, $sortDir);
        }

        $matieresAll = $query->count();
        $matieres = $query->get();

        return view('user.matieres', compact('etudiant', 'matieres', 'matieresAll'));
    }

    public function examens(Etudiant $etudiant, Request $request)
    {
        $query = Examen::with(['matiere', 'typeExamen'])
            ->whereHas('matiere', fn ($q) =>
                $q->where('filiere_id', $etudiant->filiere_id)
            )
            ->whereHas('matiere', fn ($q) =>
                $q->where('annee_academique_id', $etudiant->annee_academique_id)
            );

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if ($request->filled('type_examen')) {
            $query->where('type_examen_id', $request->type_examen);
        }
        if ($request->filled('date_min')) {
            $query->whereDate('date_examen', '>=', $request->date_min); // date_min au format YYYY-MM-DD
        }
        if ($request->filled('date_max')) {
            $query->whereDate('date_examen', '<=', $request->date_max); // date_max au format YYYY-MM-DD
        }
        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }

        $sortBy  = $request->get('sort_by', 'id');
        $sortDir = $request->get('sort_dir', 'asc');

        $allowedSorts = ['id', 'type', 'date', 'matiere'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }

        $query->select('examens.*'); // OBLIGATOIRE

        switch ($sortBy) {

            case 'id':
                $query->orderBy('id',$sortDir);
                break;

            case 'type':
                $query->leftJoin('type_examens', 'type_examens.id', '=', 'examens.type_examen_id')
                    ->orderBy('type_examens.nom', $sortDir);
                break;

            case 'date':
                $query->orderBy('date_examen', $sortDir);
                break;

            case 'matiere':
                $query->leftJoin('matieres', 'matieres.id', '=', 'examens.matiere_id')
                    ->orderBy('matieres.nom', $sortDir);
                break;

            default:
                $query->orderBy('examens.' . $sortBy, $sortDir);
        }

        $examensAll = $query->count();
        $examens = $query->get();
        $matieres = $examens
            ->pluck('matiere')
            ->filter()
            ->unique('id');
        $types = TypeExamen::all();

        return view('user.examens', compact('etudiant', 'examens', 'examensAll', 'matieres', 'types'));
    }
}
