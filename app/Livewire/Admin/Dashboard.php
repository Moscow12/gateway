<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    
    public function logout()
    {
        Auth::logout();

        return $this->redirect('/login', navigate: true);
    }

    public function index()
    {
        return view('livewire.admin.dashboard');
    }

    public function location()
    {
        return view('livewire.admin.location');
    }
}
