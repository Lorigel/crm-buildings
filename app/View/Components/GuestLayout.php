<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */

    public $name;

    public function __construct($pageName = null)
    {
        $this->name = $pageName;
    }

    public function render()
    {
        return view('layouts.guest');
    }
}
