<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MatiereRequest;
use App\Models\AnneeAcademique;
use App\Models\AnneeFiliere;
use App\Models\Examen;
use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\MoyenneMatiere;
use App\Models\Note;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Matiere::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }
        if ($request->filled('coefficient')) {
            $query->where('coefficient', 'like', '%' . $request->coefficient . '%');
        }
        if ($request->filled('filiere_id')) {
            $query->where('filiere_id', $request->filiere_id);
        }
        if ($request->filled('annee_academique_id')) {
            $query->where('annee_academique_id', $request->annee_academique_id);
        }

        $sortBy  = $request->get('sort_by', 'id');
        $sortDir = $request->get('sort_dir', 'asc');

        $allowedSorts = ['id', 'nom' ,'coef', 'filiere', 'annee'];
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

            case 'filiere':
                $query->leftJoin('filieres', 'filieres.id', '=', 'matieres.filiere_id')
                    ->orderBy('filieres.nom', $sortDir);
                break;

            case 'annee':
                $query->leftJoin('annee_academiques', 'annee_academiques.id', '=', 'matieres.annee_academique_id')
                    ->orderBy('annee_academiques.nom', $sortDir);
                break;

            default:
                $query->orderBy('matieres.' . $sortBy, $sortDir);
        }

        $matieresAll = $query->count();

        $matieres = $query->with(['filiere', 'anneeAcademique'])->paginate(20)->withQueryString();

        $filieres = Filiere::all();
        $annees = AnneeAcademique::all();
        $anneeFilieres = AnneeFiliere::all();

        return view('admin.matieres.index', compact('matieres', 'filieres', 'annees', 'anneeFilieres', 'matieresAll', 'sortBy', 'sortDir'));
    }

    public function create()
    {
        $annees = AnneeAcademique::all();
        $anneeFilieres = AnneeFiliere::all();
        $filieres = Filiere::all();
        $matiere = new Matiere();

        return view('admin.matieres.formulaire', compact('matiere', 'annees', 'anneeFilieres'));
    }

    public function store(MatiereRequest $request)
    {
        $request->validated();


        Matiere::create($request->all());

        return redirect()->route('admin.matieres.index', ['page' => $request->page])
            ->with('success', 'Matière ajoutée avec succès');
    }

    public function edit(Matiere $matiere)
    {
        $annees = AnneeAcademique::all();
        $anneeFilieres = AnneeFiliere::with('filiere')->get();

        return view('admin.matieres.formulaire', compact('matiere', 'annees', 'anneeFilieres'));
    }

    public function update(MatiereRequest $request, Matiere $matiere)
    {
        $request->validated();
        $matiere->update($request->all());

        return redirect()->route('admin.matieres.index', ['page' => $request->page])
            ->with('success', 'Matière modifiée avec succès');
    }

    public function destroy(Matiere $matiere)
    {
        $matiere->delete();

        return redirect()->route('admin.matieres.index')
            ->with('success', 'Matière supprimée');
    }

    public function notes(Matiere $matiere, Request $request)
    {
        $examens = $matiere->examens()
            ->with([
                'typeExamen',
                'notes' => function ($q) use ($matiere) {
                    $q->whereHas('etudiant', function ($q2) use ($matiere) {
                        $q2->where('annee_academique_id', $matiere->annee_academique_id);
                    })->with('etudiant');
                }
            ])
            ->get();

        $resultats = [];

        foreach ($examens as $examen) {
            foreach ($examen->notes as $note) {

                $etudiantId = $note->etudiant->id;

                if (!isset($resultats[$etudiantId])) {
                    $resultats[$etudiantId] = [
                        'nom' => $note->etudiant->nom,
                        'prenom' => $note->etudiant->prenom,
                        'cc' => null,
                        'final' => null,
                        'moyenne' => null,
                    ];
                }

                if ($examen->typeExamen->nom === 'Contrôle Continu') {
                    $resultats[$etudiantId]['cc'] = $note->valeur;
                }

                if ($examen->typeExamen->nom === 'Examen Final') {
                    $resultats[$etudiantId]['final'] = $note->valeur;
                }
            }
        }

        // Moyenne par matière (si tu as la table moyenne_matieres)
        $moyennes = MoyenneMatiere::where('matiere_id', $matiere->id)->get();

        foreach ($moyennes as $m) {
            if (isset($resultats[$m->etudiant_id])) {
                $resultats[$m->etudiant_id]['moyenne'] = $m->moyenne;
            }
        }

        $ccMin = $request->cc_min;
        $ccMax = $request->cc_max;
        $finalMin = $request->final_min;
        $finalMax = $request->final_max;
        $moyMin = $request->moyenne_min;
        $moyMax = $request->moyenne_max;

        $filtres = [];
        $notesAll = 0;

        foreach ($resultats as $rs) {
            // 🔍 FILTRES
            if ($ccMin !== null && $rs['cc'] < $ccMin) continue;
            if ($ccMax !== null && $rs['cc'] > $ccMax) continue;

            if ($finalMin !== null && $rs['final'] < $finalMin) continue;
            if ($finalMax !== null && $rs['final'] > $finalMax) continue;

            if ($moyMin !== null && $rs['moyenne'] < $moyMin) continue;
            if ($moyMax !== null && $rs['moyenne'] > $moyMax) continue;

            $filtres[] = $rs;
            $notesAll++;
        }
        
        return view('admin.matieres.notes', [
                'examens' => $filtres,
                'matiere' => $matiere
            ], compact('notesAll'));    
    }
}
