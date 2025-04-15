<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Userprofile extends Component
{
    public $user;
    public function render()
    {
        return view('livewire.admin.userprofile');
    }

    public function mount()
    {
        $this->user = Auth::user();
    }
}
