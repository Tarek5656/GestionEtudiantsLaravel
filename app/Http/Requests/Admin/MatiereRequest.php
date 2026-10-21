<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MatiereRequest extends FormRequest
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
        $matiereId = $this->route('matiere')?->id ?? null;

        return [
            'nom' => [
                'required',
                'string',
                'max:20',
                'unique:matieres,nom,' . $matiereId . ',id'            
            ],
            'annee_academique_id' => [
                'required',
                'exists:annee_academiques,id'
            ],
            'filiere_id' => [
                'required',
                'exists:filieres,id'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // ===== NOM =====
            'nom.required' => 'Le nom est obligatoire.',
            'nom.string'   => 'Le nom doit être une chaîne de caractères.',
            'nom.max'      => 'Le nom ne doit pas dépasser 20 caractères.',
            'nom.unique'   => 'Ce nom de matière existe déjà.',

            // ===== ANNÉE ACADÉMIQUE =====
            'annee_academique_id.required' => 'Veuillez sélectionner une année académique.',
            'annee_academique_id.exists'   => 'L’année académique sélectionnée est invalide.',

            // ===== FILIÈRE =====
            'filiere_id.required' => 'Veuillez sélectionner une filière.',
            'filiere_id.exists'   => 'La filière sélectionnée est invalide.',
        ];
    }
}
