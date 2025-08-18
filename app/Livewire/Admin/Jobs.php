<?php

namespace App\Livewire\Admin;

use App\Models\Jobapplications;
use Livewire\Component;
use Livewire\WithPagination;

class Jobs extends Component
{
    public $page = 'jobslist';
    public $search='', $applicant;
    use WithPagination;

    public function render()
    {        
        return view('livewire.admin.jobs', [
            'applicantslists' => Jobapplications::where('status','active')
            ->where(
                fn($query) => $query
                    ->orWhere('phone', 'like', '%' . $this->search . '%')
                    ->orWhere('ApplicantName', 'like', '%' . $this->search . '%')
            )->paginate(15)
        ]);
    }
    public function mount() : void
    {
        $this->applicant = new Jobapplications;
    }
    public function viewattachments(Jobapplications $applicant)
    {
        // $applicant = Jobapplications::find($id);
        // return view('livewire.admin.jobs', [
        //     $applicant
        // ]);

        $this->applicant = $applicant;
        $this->dispatch('modal-show', 'jabad');
    }

   

    

   
}
