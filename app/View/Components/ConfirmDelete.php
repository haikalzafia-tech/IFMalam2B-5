<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class ConfirmDelete extends Component
{
    public $route;
    public $id;

    /**
     * Create a new component instance.
     */
    public function __construct($route, $id)
    {
        $this->route = $route;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // Pengecekan role juga bisa dilakukan di sini jika ingin mencegah view dirender sama sekali
        return view('components.confirm-delete');
    }
}
