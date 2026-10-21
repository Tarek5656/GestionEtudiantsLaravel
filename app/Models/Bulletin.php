<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    //
    use HasFactory;
    protected $fillable = ['moyenne_generale', 'valider', 'etudiant_id', 'filiere_id', 'annee_academique_id'];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class);
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'etudiant_id', 'etudiant_id');
    }

    public function moyenneMatieres()
    {
        return $this->hasMany(MoyenneMatiere::class);
    }
}
