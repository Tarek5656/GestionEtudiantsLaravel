<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Examen;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\TypeExamen;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    //
    public function formulaire(Etudiant $etudiant)
{
    $etudiant->load(['notes.examen.typeExamen', 'filiere', 'anneeAcademique']);

    // Récupérer toutes les matières de la filière + année
    $matieres = Matiere::where('filiere_id', $etudiant->filiere_id)
    ->where('annee_academique_id', $etudiant->annee_academique_id)
    ->with(['examens.typeExamen']) // bien charger typeExamen
    ->get()
    ->map(function ($matiere) use ($etudiant) {
        $cc = null;
        $final = null;
        $cc_exam_id = null;
        $final_exam_id = null;

        foreach ($matiere->examens as $examen) {
            if (!$examen->typeExamen) continue; // sécurité
            $note = $etudiant->notes->firstWhere('examen_id', $examen->id);

            $typeNom = trim(strtolower($examen->typeExamen->nom)); // mettre en minuscule
            if ($typeNom === 'contrôle continu' || $typeNom === 'cc') {
                $cc = $note->valeur ?? null;
                $cc_exam_id = $examen->id;
            } elseif ($typeNom === 'examen final' || $typeNom === 'final') {
                $final = $note->valeur ?? null;
                $final_exam_id = $examen->id;
            }
        }

        return [
            'id' => $matiere->id,
            'nom' => $matiere->nom,
            'coef' => $matiere->coefficient ?? 1,
            'cc' => $cc,
            'final' => $final,
            'cc_exam_id' => $cc_exam_id,
            'final_exam_id' => $final_exam_id,
        ];
    });

    return view('admin.etudiants.notes', compact('etudiant', 'matieres'));
}

    public function store(Request $request)
{
    $etudiantId = $request->input('etudiant_id');
    $notes = $request->input('notes', []);

    $matieresSansExamen = [];

    foreach ($notes as $key => $valeur) {

        if ($valeur === null || $valeur === '') {
            continue;
        }

        $examen = null;

        // ================= CC =================
        if (str_starts_with($key, 'new_cc_')) {

            $matiereId = (int) str_replace('new_cc_', '', $key);
            $typeNom = 'Contrôle Continu';

            $typeExamen = TypeExamen::where('nom', $typeNom)->first();

            if (!$typeExamen) {
                $matieresSansExamen[] = [
                    'matiere_id' => $matiereId,
                    'matiere' => Matiere::find($matiereId)?->nom ?? "ID $matiereId",
                    'type' => $typeNom,
                ];
                continue;
            }

            $examen = Examen::where('matiere_id', $matiereId)
                ->where('type_examen_id', $typeExamen->id)
                ->first();

            if (!$examen) {
                $matieresSansExamen[] = [
                    'matiere_id' => $matiereId,
                    'matiere' => Matiere::find($matiereId)?->nom ?? "ID $matiereId",
                    'type' => $typeNom,
                ];
                continue;
            }
        }

        // ================= FINAL =================
        elseif (str_starts_with($key, 'new_final_')) {

            $matiereId = (int) str_replace('new_final_', '', $key);
            $typeNom = 'Final';

            $typeExamen = TypeExamen::where('nom', $typeNom)->first();

            if (!$typeExamen) {
                $matieresSansExamen[] = [
                    'matiere_id' => $matiereId,
                    'matiere' => Matiere::find($matiereId)?->nom ?? "ID $matiereId",
                    'type' => $typeNom,
                ];
                continue;
            }

            $examen = Examen::where('matiere_id', $matiereId)
                ->where('type_examen_id', $typeExamen->id)
                ->first();

            if (!$examen) {
                $matieresSansExamen[] = [
                    'matiere_id' => $matiereId,
                    'matiere' => Matiere::find($matiereId)?->nom ?? "ID $matiereId",
                    'type' => $typeNom,
                ];
                continue;
            }
        }

        // ================= EXISTANT =================
        else {
            $examen = Examen::find($key);
            if (!$examen) {
                continue;
            }
        }

        // Enregistrer la note
        Note::updateOrCreate(
            [
                'etudiant_id' => $etudiantId,
                'examen_id' => $examen->id,
            ],
            [
                'valeur' => $valeur
            ]
        );
    }

    // Supprimer doublons (matière + type)
    $matieresSansExamen = collect($matieresSansExamen)
        ->unique(fn ($item) => $item['matiere_id'].'_'.$item['type'])
        ->values()
        ->all();

    return redirect()
        ->route('admin.etudiants.bulletin', [$etudiantId, 'page' => $request->page])
        ->with('success', 'Notes mises à jour avec succès')
        ->with('examens_inexistants', $matieresSansExamen);
}

}