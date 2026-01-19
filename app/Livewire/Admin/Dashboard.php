<?php

namespace App\Livewire\Admin;

use App\Models\advertvacancies;
use App\Models\Jobapplications;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public $applicants, $vacancies, $jobs;
    public function logout()
    {
        Auth::logout();

        return $this->redirect('/login', navigate: true);
    }

   

    public function location()
    {
        return view('livewire.admin.location');
    }

    public function mount()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $this->checkapplications();
        $this->checkavailablevacancies();
        $this->checkavailablejobs();
    }

    public function checkapplications()
    {
        // list only 10 applications order descending by created_at
        $this->applicants = Jobapplications::where('status','active')->orderBy('created_at', 'desc')->limit(10)->get();
    }

    public function checkavailablevacancies()
    {
        $this->vacancies = advertvacancies::where('status','active')->get();
    }

    public function checkavailablejobs()
    {
        $this->jobs = Jobapplications::where('status','active')->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
