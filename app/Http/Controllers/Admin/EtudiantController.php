<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EtudiantRequest;
use App\Models\AnneeAcademique;
use App\Models\AnneeFiliere;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Sexe;
use App\Models\User;
use App\Services\BulletinService;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Etudiant::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }
        if ($request->filled('prenom')) {
            $query->where('prenom', 'like', '%' . $request->prenom . '%');
        }
        if ($request->filled('sexe_id')) {
            $query->where('sexe_id', $request->sexe_id);
        }
        if ($request->filled('filiere_id')) {
            $query->where('filiere_id', $request->filiere_id);
        }
        if ($request->filled('annee_academique_id')) {
            $query->where('annee_academique_id', $request->annee_academique_id);
        }

        $sortBy  = $request->get('sort_by', 'id');
        $sortDir = $request->get('sort_dir', 'asc');

        $allowedSorts = ['id', 'nom', 'prenom', 'sexe', 'filiere', 'annee'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }

        $query->select('etudiants.*'); // OBLIGATOIRE

        switch ($sortBy) {

            case 'id':
                $query->orderBy('id',$sortDir);
                break;

            case 'nom':
                $query->orderBy('nom', $sortDir);
                break;

            case 'prenom':
                $query->orderBy('prenom', $sortDir);
                break;

            case 'sexe':
                $query->leftJoin('sexes', 'sexes.id', '=', 'etudiants.sexe_id')
                    ->orderBy('sexes.nom', $sortDir);
                break;

            case 'filiere':
                $query->leftJoin('filieres', 'filieres.id', '=', 'etudiants.filiere_id')
                    ->orderBy('filieres.nom', $sortDir);
                break;

            case 'annee':
                $query->leftJoin('annee_academiques', 'annee_academiques.id', '=', 'etudiants.annee_academique_id')
                    ->orderBy('annee_academiques.nom', $sortDir);
                break;

            default:
                $query->orderBy('etudiants.' . $sortBy, $sortDir);
        }

        $etudiantsAll = $query->count();

        $etudiants = $query->with(['filiere', 'anneeAcademique'])->paginate(20)->withQueryString();

        $filieres = Filiere::all();
        $annees = AnneeAcademique::all();
        $anneeFilieres = AnneeFiliere::all();
        $sexes = Sexe::all();

        return view('admin.etudiants.index', compact('etudiants', 'filieres', 'annees', 'anneeFilieres', 'sexes', 'etudiantsAll', 'sortBy', 'sortDir'));
    }


    public function show(Etudiant $etudiant)
    {
        return view('admin.etudiants.show', compact('etudiant'));
    }

    public function create()
    {
        $etudiant = new Etudiant();
        $annees = AnneeAcademique::all();
        $filieres = Filiere::all();
        $anneeFilieres = AnneeFiliere::all();
        $sexes = Sexe::all();
        return view('admin.etudiants.formulaire', compact('etudiant', 'annees', 'filieres','anneeFilieres', 'sexes'));
    }

    public function store(EtudiantRequest $request)
    {
        $data = $request->validated();

        $email = strtolower($data['prenom'] . '.' . $data['nom'] . '@edu.isga.ma');
        $user = User::create([
            'name' => $data['nom'] . ' ' . $data['prenom'],
            'email' => $email,
            'password' => 'password', // Default password
        ]);
        $data['user_id'] = $user->id;
        $etudiant = Etudiant::create($data);
        $service = new BulletinService();
        $service->creerBulletinPourEtudiant($etudiant);

        return redirect()->route('admin.etudiants.index', ['page' => $request->page])->with('success', 'Etudiant ajouté');
    }

    public function edit(Etudiant $etudiant)
    {
        $annees = AnneeAcademique::all();
        $filieres = Filiere::all();
        $anneeFilieres = AnneeFiliere::all();
        $sexes = Sexe::all();
        return view('admin.etudiants.formulaire', compact('etudiant', 'annees', 'filieres', 'anneeFilieres', 'sexes'));
     }

    public function update(EtudiantRequest $request, Etudiant $etudiant)
    {
        $data = $request->validated();
        $etudiant->update($data);

        return redirect()->route('admin.etudiants.show', ['etudiant' => $etudiant, 'page' => $request->page])->with('success', 'Etudiant modifié');
    }

    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();
        $etudiant->user()->delete();
        return back()->with('success', 'Etudiant supprimé');
    }
}
