<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'nom',
        'coefficient',
        'filiere_id',
        'annee_academique_id'
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class);
    }

    public function examens()
    {
        return $this->hasMany(Examen::class);
    }

    public function notes() {
    return $this->hasManyThrough(Note::class, Examen::class);
    }

    public function moyennesMatieres() {
    return $this->hasMany(MoyenneMatiere::class);
    }

}
