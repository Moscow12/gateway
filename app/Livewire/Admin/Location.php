<?php

namespace App\Livewire\Admin;

use App\Models\Regions;
use Livewire\Component;
use Livewire\WithPagination;

class Location extends Component
{
    use WithPagination;

    public $countries, $regions;
    public function render()
    {
        return view('livewire.admin.location',[
            'regions' => Regions::paginate(10)
        ]);
    }
   
    
}

