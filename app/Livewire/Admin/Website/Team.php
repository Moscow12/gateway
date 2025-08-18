<?php

namespace App\Livewire\Admin\Website;

use App\Models\Teams;
use Livewire\Component;

class Team extends Component
{
    public function render()
    {
        $teams = Teams::all();
        return view('livewire.admin.website.team', ['teams' => $teams]);
    }
}
