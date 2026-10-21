<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExamenRequest;
use App\Models\AnneeAcademique;
use App\Models\AnneeFiliere;
use App\Models\Examen;
use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\TypeExamen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamenController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Examen::query();

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
        // Filtre par filière via relation matiere
        if ($request->filled('filiere_id')) {
            $query->whereHas('matiere', function($q) use ($request) {
                $q->where('filiere_id', $request->filiere_id);
            });
        }
        // Filtre par année académique via relation matiere
        if ($request->filled('annee_academique_id')) {
            $query->whereHas('matiere', function($q) use ($request) {
                $q->where('annee_academique_id', $request->annee_academique_id);
            });
        }

        $sortBy  = $request->get('sort_by', 'id');
        $sortDir = $request->get('sort_dir', 'asc');

        $allowedSorts = ['id', 'type', 'date', 'matiere', 'filiere', 'annee'];
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

            case 'filiere':
                $query->leftJoin('matieres', 'matieres.id', '=', 'examens.matiere_id')
                    ->rightJoin('filieres', 'filieres.id', '=' , 'matieres.filiere_id')
                    ->orderBy('filieres.nom', $sortDir);
                break;

            case 'annee':
                $query->leftJoin('matieres', 'matieres.id', '=', 'examens.matiere_id')
                    ->rightJoin('annee_academiques', 'annee_academiques.id', '=', 'matieres.annee_academique_id')
                    ->orderBy('annee_academiques.nom', $sortDir);
                break;

            default:
                $query->orderBy('examens.' . $sortBy, $sortDir);
        }

        $examensAll = $query->count();

        $examens = $query->with(['typeExamen', 'matiere'])->paginate(20)->withQueryString();

        $filieres = Filiere::all();
        $annees = AnneeAcademique::all();
        $types = TypeExamen::all();
        $matieres = Matiere::all();
        $anneeFilieres = AnneeFiliere::all();

        return view('admin.examen.index', compact('examens', 'filieres', 'annees', 'types', 'matieres', 'anneeFilieres', 'examensAll', 'sortBy', 'sortDir'));
    }

    public function create()
    {
        $examen = new Examen();
        $matieres = Matiere::all();
        $annees = AnneeAcademique::all();
        $filieres = Filiere::all();
        $anneeFilieres = AnneeFiliere::all();
        $typeExamens = TypeExamen::all();
        return view('admin.examen.formulaire', compact('examen', 'matieres', 'annees', 'filieres', 'anneeFilieres', 'typeExamens'));
    }

    public function store(ExamenRequest $request)
    {
        $data = $request->validated();
        Examen::create($data);

        return redirect()->route('admin.examens.index', ['page' => $request->page])->with('success', 'Exam ajouté');
    }

    public function edit(Examen $examen)
    {
        $matieres = Matiere::all();
        $annees = AnneeAcademique::all();
        $filieres = Filiere::all();
        $anneeFilieres = AnneeFiliere::all();
        $typeExamens = TypeExamen::all();
        return view('admin.examen.formulaire', compact('examen', 'matieres', 'annees', 'filieres', 'anneeFilieres', 'typeExamens'));
    }

    public function update(ExamenRequest $request, Examen $examen)
    {
        $data = $request->validated();
        $examen->update($data);

        return redirect()->route('admin.examens.index', ['page' => $request->page])->with('success', 'Examen modifié');
    }

    public function destroy(Examen $examen)
    {
        $examen->delete();
        return back()->with('success', 'Examen supprimé');
    }
}
