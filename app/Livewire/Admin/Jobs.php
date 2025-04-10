<?php

namespace App\Livewire\Admin;

use App\Models\Jobapplications;
use Livewire\Component;

class Jobs extends Component
{
    public $page = 'jobslist';
    public $applicantslist;

    // public function jobslist()
    // {
    //     return view('livewire.admin.jobs');
    // }

    // public function applicants()
    // {
    //     return view('livewire.admin.applicants');
    // }

    public function mount()
    {
        $this->page = request()->routeIs('applicants') ? 'applicants' : 'jobslist';
        $this->applicantslist = Jobapplications::all();

    }

    public function render()
    {
        return view('livewire.admin.' . $this->page);
    }
}
