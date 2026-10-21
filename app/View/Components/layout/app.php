<?php

namespace App\View\Components\layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class app extends Component
{
    /**
     * Create a new component instance.
     */
    public $role;
    public function __construct()
    {
        //
        $this->role = auth()->check() ? auth()->user()->role : 'user';

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.app');
    }
}
