<?php

namespace App\Livewire\Admin;

use App\Models\Jobapplications;
use Livewire\Component;
use Livewire\WithPagination;

class Shortlisted extends Component
{
    public $applicant, $applicantslists, $search, $status='Approved';
    public $paginationTheme = 'bootstrap';

    public function mount() : void
    {
        $this->filterlist();
    }

    public function filterlist(){
        $this->applicantslists = Jobapplications::where('status',$this->status)
            ->where(
                fn($query) => $query
                    ->orWhere('phone', 'like', '%' . $this->search . '%')
                    ->orWhere('ApplicantName', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
            )->get();
    }

    public function render()
    {
        return view('livewire.admin.shortlisted');
    }
}
