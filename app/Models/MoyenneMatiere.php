<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoyenneMatiere extends Model
{
    //
    use HasFactory;
    protected $fillable = ['moyenne', 'matiere_id', 'etudiant_id'];

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function bulletin()
    {
        return $this->belongsTo(Bulletin::class, 'etudiant_id', 'etudiant_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'etudiant_id', 'etudiant_id')
                    ->whereHas('examen', function ($query) {
                        $query->where('matiere_id', $this->matiere_id);
                    });
    }

    public function validation()
    {
        return $this->hasOne(Validation::class);
    }
}
