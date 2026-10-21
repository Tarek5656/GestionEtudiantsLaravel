<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EtudiantRequest extends FormRequest
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
        // Si on est en update, récupérer l'ID depuis la route
        $etudiantId = $this->route('etudiant')?->id ?? null;

        return [
            'nom' => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZÀ-ÿ\s\-]+$/'],
            'prenom' => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZÀ-ÿ\s\-]+$/'],
            'date_naissance' => ['required', 'date', 'before:today', 'after:1960-01-01'],
            'cin' => ['required', 'string', 'min:8', 'max:8', 'regex:/^[A-Z0-9]+$/', 'unique:etudiants,cin,' . $etudiantId . ',id'],
            'sexe_id' => ['required', 'exists:sexes,id'],
            'email' => ['required', 'email', 'max:30', 'unique:etudiants,email,' . $etudiantId . ',id'],
            'adresse' => ['required', 'string', 'max:80'],
            'telephone' => ['required', 'digits:10', 'unique:etudiants,telephone,' . $etudiantId . ',id'],
            'filiere_id' => ['required', 'exists:filieres,id'],
            'annee_academique_id' => ['required', 'exists:annee_academiques,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.string' => 'Le nom doit être du texte.',
            'nom.max' => 'Le nom ne peut pas dépasser 20 caractères.',
            'nom.regex' => 'Le nom ne peut contenir que des lettres, espaces ou tirets.',

            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.string' => 'Le prénom doit être du texte.',
            'prenom.max' => 'Le prénom ne peut pas dépasser 20 caractères.',
            'prenom.regex' => 'Le prénom ne peut contenir que des lettres, espaces ou tirets.',

            'date_naissance.required' => 'La date de naissance est obligatoire.',
            'date_naissance.date' => 'La date de naissance doit être valide.',
            'date_naissance.before' => 'La date de naissance doit être avant aujourd’hui.',
            'date_naissance.after' => 'La date de naissance doit être après 01-01-1960.',

            'cin.required' => 'Le CIN est obligatoire.',
            'cin.min' => 'Le CIN doit contenir exactement 8 caractères.',
            'cin.max' => 'Le CIN doit contenir exactement 8 caractères.',
            'cin.regex' => 'Le CIN ne peut contenir que des lettres majuscules et des chiffres.',
            'cin.unique' => 'Ce CIN est déjà utilisé.',

            'sexe_id.required' => 'Le sexe est obligatoire',
            'sexe_id.exists' => 'Le sexe choisie n’existe pas.',

            'email.required' => 'L’email est obligatoire.',
            'email.email' => 'L’email doit être valide (ex: nom@domaine.com).',
            'email.max' => 'L’email ne peut pas dépasser 30 caractères.',
            'email.unique' => 'Cet email est déjà utilisé.',

            'adresse.required' => 'L’adresse est obligatoire.',
            'adresse.string' => 'L’adresse doit être du texte.',
            'adresse.max' => 'L’adresse ne peut pas dépasser 80 caractères.',

            'telephone.required' => 'Le téléphone est obligatoire.',
            'telephone.digits' => 'Le téléphone doit contenir exactement 10 chiffres.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',

            'filiere_id.required' => 'La filière est obligatoire.',
            'filiere_id.exists' => 'La filière choisie n’existe pas.',

            'annee_academique_id.required' => 'L’année académique est obligatoire.',
            'annee_academique_id.exists' => 'L’année académique choisie n’existe pas.',
        ];
    }
}
