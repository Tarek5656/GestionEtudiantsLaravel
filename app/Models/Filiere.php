<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    //
    use HasFactory;

    protected $fillable = ['nom', 'description', 'parent_id'];

    public function annees()
    {
        return $this->belongsToMany(AnneeAcademique::class, 'annee_filieres');
    }

    public function parent()
    {
        return $this->belongsTo(Filiere::class, 'parent_id');
    }

    public function enfants()
    {
        return $this->hasMany(Filiere::class, 'parent_id');
    }

    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }
}
