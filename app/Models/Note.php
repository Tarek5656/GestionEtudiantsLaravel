<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //
    use HasFactory;

    protected $fillable = ['valeur', 'etudiant_id', 'examen_id'];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }

    public function bulletin()
    {
        return $this->belongsTo(Bulletin::class, 'etudiant_id', 'etudiant_id');
    }
}
