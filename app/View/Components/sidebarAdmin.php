<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarAdmin extends Component
{


    public function __construct()
    {
        // Menyimpan data pengguna
    }

    public function render()
    {
        return view('components.sidebar');
    }
}
