<?php

namespace App\Livewire\Admin;

use App\Models\Advertvacancies;
use App\Models\Jobapplications;
use Livewire\Component;
use Livewire\WithPagination;

class Jobs extends Component
{
    use WithPagination;

    public $page = 'jobslist';
    public $status = '';
    public $vacancyFilter = '';
    public $search = '';
    public $applicant;
    public $applicantslists = [];
    public $vacancies = [];

    public function mount(): void
    {
        $this->vacancies = Advertvacancies::orderBy('title')->get();
        $this->refreshApplicantsList();
    }

    public function render()
    {
        return view('livewire.admin.jobs');
    }

    public function refreshApplicantsList()
    {
        $query = Jobapplications::with('vacancy');

        // Filter by status if selected
        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        // Filter by vacancy if selected
        if (!empty($this->vacancyFilter)) {
            $query->where('vacancyID', $this->vacancyFilter);
        }

        // Search by name, phone, or email
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('ApplicantName', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%')
                  ->orWhere('ApplicantEmail', 'like', '%' . $this->search . '%');
            });
        }

        $this->applicantslists = $query->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();
    }

    public function updatedSearch()
    {
        $this->refreshApplicantsList();
    }

    public function updatedStatus()
    {
        $this->refreshApplicantsList();
    }

    public function updatedVacancyFilter()
    {
        $this->refreshApplicantsList();
    }

    public function clearFilters()
    {
        $this->status = '';
        $this->vacancyFilter = '';
        $this->search = '';
        $this->refreshApplicantsList();
    }

    public function viewattachments(Jobapplications $applicant)
    {
        $this->applicant = $applicant;
        $this->dispatch('modal-show', 'jabad');
    }
}
