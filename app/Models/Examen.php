<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    //
    use HasFactory;

    protected $fillable = ['type_examen_id', 'date_examen', 'matiere_id'];
     protected $casts = [
        'date_examen' => 'date', // <--- ici
    ];

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function typeExamen()
    {
        return $this->belongsTo(TypeExamen::class);
    }
}
