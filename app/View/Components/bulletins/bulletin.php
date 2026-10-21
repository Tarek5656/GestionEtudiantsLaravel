<?php

namespace App\View\Components\bulletins;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class bulletin extends Component
{
    /**
     * Create a new component instance.
     */
    public $etudiant;
    public $bulletin;
    public $matieres;
    public function __construct($etudiant, $bulletin, $matieres)
    {
        $this->etudiant = $etudiant;
        $this->bulletin = $bulletin;
        $this->matieres = $matieres;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.bulletins.bulletin');
    }
}
