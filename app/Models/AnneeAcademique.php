<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeAcademique extends Model
{
    //
    use HasFactory;

    protected $fillable = ['nom', 'niveau'];

    public function filieres()
    {
        return $this->belongsToMany(Filiere::class, 'annee_filieres');
    }

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function bulletins()
    {
        return $this->hasMany(Bulletin::class);
    }
}
