<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    //
    use HasFactory;

    protected $fillable = ['nom', 'prenom', 'email', 'sexe_id', 'cin', 'date_naissance', 'adresse', 'telephone', 'filiere_id', 'annee_academique_id', 'user_id'];
    protected $casts = [
    'date_naissance' => 'date', // maintenant $etudiant->date_naissance est un Carbon
];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function moyennesMatieres() {
    return $this->hasMany(MoyenneMatiere::class);
}

    public function bulletins()        // historique
    {
        return $this->hasMany(Bulletin::class);
    }

    public function getBulletinCourantAttribute()
    {
        return $this->bulletins
            ->where('annee_academique_id', $this->annee_academique_id)
            ->first();
    }

    public function examens()
    {
        return $this->hasManyThrough(Examen::class, Note::class);
    }

    public function sexe()
    {
        return $this->belongsTo(Sexe::class);
    }
}
