<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExamenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         $examenId = $this->route('examen')?->id ?? null;

        return [
            'type_examen_id' => [
                'required',
                'exists:type_examens,id',
                Rule::unique('examens')
                ->where(fn ($q) => $q
                    ->where('matiere_id', $this->matiere_id)
                )
                ->ignore($examenId),
            ],
            'date_examen' => [
                'required',
                'date',
                'after:today',
                Rule::unique('examens')->where(function ($query) {
                    return $query->where('matiere_id', $this->matiere_id);
                })->ignore($examenId),
            ],
            'matiere_id' => [
                'required',
                'exists:matieres,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // ===== TYPE EXAMEN =====
            'type_examen_id.required' => 'Veuillez sélectionner le type d’examen.',
            'type_examen_id.exists'   => 'Le type d’examen sélectionné est invalide.',
            'type_examen_id.unique'   => 'Ce type d’examen existe déjà.',

            // ===== DATE EXAMEN =====
            'date_examen.required' => 'La date de l’examen est obligatoire.',
            'date_examen.date'     => 'La date de l’examen n’est pas valide.',
            'date_examen.after'    => 'La date de l’examen doit être postérieure à aujourd’hui.',
            'date_examen.unique'   => 'Un examen pour cette matière existe déjà à cette date.',

            // ===== MATIÈRE =====
            'matiere_id.required' => 'Veuillez sélectionner une matière.',
            'matiere_id.exists'   => 'La matière sélectionnée est invalide.',
        ];
    }
}
