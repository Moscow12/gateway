<?php

namespace App\Livewire\Admin;

use App\Models\ContactRequest;
use Livewire\Component;
use Livewire\WithPagination;

class ContactRequests extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $statusFilter = '';
    public $priorityFilter = '';
    public $perPage = 10;

    // View Modal
    public $showViewModal = false;
    public $viewingRequest = null;

    // Acknowledge Modal
    public $showAcknowledgeModal = false;
    public $acknowledgingRequest = null;
    public $acknowledgeNotes = '';
    public $newStatus = 'in_progress';

    // Delete Modal
    public $showDeleteModal = false;
    public $deletingRequest = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'priorityFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingPriorityFilter()
    {
        $this->resetPage();
    }

    public function viewRequest($id)
    {
        $this->viewingRequest = ContactRequest::with('acknowledgedBy')->find($id);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewingRequest = null;
    }

    public function openAcknowledgeModal($id)
    {
        $this->acknowledgingRequest = ContactRequest::find($id);
        $this->acknowledgeNotes = $this->acknowledgingRequest->notes ?? '';
        $this->newStatus = $this->acknowledgingRequest->status === 'new' ? 'in_progress' : $this->acknowledgingRequest->status;
        $this->showAcknowledgeModal = true;
    }

    public function closeAcknowledgeModal()
    {
        $this->showAcknowledgeModal = false;
        $this->acknowledgingRequest = null;
        $this->acknowledgeNotes = '';
        $this->newStatus = 'in_progress';
    }

    public function acknowledge()
    {
        if (!$this->acknowledgingRequest) {
            return;
        }

        $this->acknowledgingRequest->update([
            'status' => $this->newStatus,
            'notes' => $this->acknowledgeNotes,
            'acknowledged_by' => auth()->id(),
            'acknowledged_at' => $this->acknowledgingRequest->acknowledged_at ?? now(),
        ]);

        $this->closeAcknowledgeModal();
        session()->flash('message', 'Contact request has been updated successfully.');
    }

    public function updatePriority($id, $priority)
    {
        $request = ContactRequest::find($id);
        if ($request) {
            $request->update(['priority' => $priority]);
            session()->flash('message', 'Priority updated successfully.');
        }
    }

    public function confirmDelete($id)
    {
        $this->deletingRequest = ContactRequest::find($id);
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingRequest = null;
    }

    public function delete()
    {
        if ($this->deletingRequest) {
            $this->deletingRequest->delete();
            session()->flash('message', 'Contact request has been deleted.');
        }
        $this->closeDeleteModal();
    }

    public function render()
    {
        $requests = ContactRequest::query()
            ->with('acknowledgedBy')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('subject', 'like', '%' . $this->search . '%')
                        ->orWhere('company', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->priorityFilter, function ($query) {
                $query->where('priority', $this->priorityFilter);
            })
            ->orderByRaw("FIELD(status, 'new', 'in_progress', 'resolved', 'closed')")
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $stats = [
            'total' => ContactRequest::count(),
            'new' => ContactRequest::where('status', 'new')->count(),
            'in_progress' => ContactRequest::where('status', 'in_progress')->count(),
            'resolved' => ContactRequest::where('status', 'resolved')->count(),
        ];

        return view('livewire.admin.contact-requests', [
            'requests' => $requests,
            'stats' => $stats,
            'statuses' => ContactRequest::STATUSES,
            'priorities' => ContactRequest::PRIORITIES,
        ]);
    }
}
