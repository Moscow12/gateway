<?php

namespace App\Livewire\Admin;

use App\Models\InterviewScore;
use App\Models\Jobapplications;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Applicantdetails extends Component
{
    public $id;
    public $applicantdata;
    public $isEditMode = false;
    public $gender, $maritalStatus, $dob, $Nida, $Location, $status, $Remarks, $age;

    // Score properties
    public $scores = [];
    public $criteria = '';
    public $score = '';
    public $maxScore = 100;
    public $scoreRemarks = '';
    public $editingScoreId = null;

    public function mount($id)
    {
        $this->loadApplicant($id);
    }

    public function loadApplicant($id)
    {
        $this->applicantdata = Jobapplications::with(['vacancy', 'scores.scorer'])->findOrFail($id);
        $this->gender = $this->applicantdata->Gender;
        $this->maritalStatus = $this->applicantdata->MaritalStatus;
        $this->dob = $this->applicantdata->dob;
        $this->status = $this->applicantdata->status;
        $this->age = Carbon::parse($this->dob)->age;
        $this->Nida = $this->applicantdata->Nida;
        $this->Location = $this->applicantdata->Location;
        $this->Remarks = $this->applicantdata->Remarks;
        $this->scores = $this->applicantdata->scores;
    }

    public function saveapplication()
    {
        $this->validate([
            'status' => 'required|string|max:255',
            'Remarks' => 'nullable|string|max:1000',
        ]);

        $this->applicantdata->update([
            'status' => $this->status,
            'Remarks' => $this->Remarks,
        ]);

        session()->flash('message', 'Application updated successfully.');
    }

    public function saveScore()
    {
        $this->validate([
            'criteria' => 'required|string|max:255',
            'score' => 'required|numeric|min:0|max:' . $this->maxScore,
            'maxScore' => 'required|numeric|min:1|max:1000',
            'scoreRemarks' => 'nullable|string|max:500',
        ]);

        if ($this->editingScoreId) {
            // Update existing score
            $interviewScore = InterviewScore::find($this->editingScoreId);
            if ($interviewScore) {
                $interviewScore->update([
                    'criteria' => $this->criteria,
                    'score' => $this->score,
                    'max_score' => $this->maxScore,
                    'remarks' => $this->scoreRemarks,
                ]);
                session()->flash('score_message', 'Score updated successfully.');
            }
        } else {
            // Create new score
            InterviewScore::create([
                'applicant_id' => $this->applicantdata->id,
                'criteria' => $this->criteria,
                'score' => $this->score,
                'max_score' => $this->maxScore,
                'remarks' => $this->scoreRemarks,
                'scored_by' => Auth::id(),
            ]);
            session()->flash('score_message', 'Score added successfully.');
        }

        $this->resetScoreForm();
        $this->loadApplicant($this->applicantdata->id);
    }

    public function editScore($scoreId)
    {
        $score = InterviewScore::find($scoreId);
        if ($score) {
            $this->editingScoreId = $scoreId;
            $this->criteria = $score->criteria;
            $this->score = $score->score;
            $this->maxScore = $score->max_score;
            $this->scoreRemarks = $score->remarks;
        }
    }

    public function deleteScore($scoreId)
    {
        $score = InterviewScore::find($scoreId);
        if ($score) {
            $score->delete();
            session()->flash('score_message', 'Score deleted successfully.');
            $this->loadApplicant($this->applicantdata->id);
        }
    }

    public function cancelEdit()
    {
        $this->resetScoreForm();
    }

    public function resetScoreForm()
    {
        $this->editingScoreId = null;
        $this->criteria = '';
        $this->score = '';
        $this->maxScore = 100;
        $this->scoreRemarks = '';
    }

    public function render()
    {
        return view('livewire.admin.applicantdetails');
    }
}
