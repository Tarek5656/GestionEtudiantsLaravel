<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    //
    use HasFactory;

    protected $fillable = ['valide', 'moyenne_matiere_id'];

    public function moyenneMatiere()
    {
        return $this->belongsTo(MoyenneMatiere::class);
    }
}
