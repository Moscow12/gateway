<?php

namespace App\Livewire\Admin;

use App\Models\Partner;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PartnerManager extends Component
{
    use WithFileUploads, WithPagination;

    public $name, $logo, $website, $description, $partner_type;
    public $existing_logo;
    public $is_active = true, $order = 0;
    public $partnerId;
    public $isEditMode = false;
    public $filterType = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'logo' => 'nullable|image|max:2048',
        'website' => 'nullable|url|max:255',
        'description' => 'nullable|string',
        'partner_type' => 'required|string|max:50',
        'is_active' => 'boolean',
        'order' => 'integer|min:0',
    ];

    public function render()
    {
        $query = Partner::ordered();

        if ($this->filterType) {
            $query->ofType($this->filterType);
        }

        return view('livewire.admin.partner-manager', [
            'partners' => $query->paginate(12),
            'partnerTypes' => Partner::getTypes(),
        ]);
    }

    public function save()
    {
        $rules = $this->rules;
        if (!$this->isEditMode) {
            $rules['logo'] = 'required|image|max:2048';
        }
        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'website' => $this->website,
            'description' => $this->description,
            'partner_type' => $this->partner_type,
            'is_active' => $this->is_active,
            'order' => $this->order,
            'added_by' => Auth::id(),
        ];

        if ($this->logo) {
            $data['logo'] = $this->logo->store('partners', 'public');
        }

        if ($this->isEditMode && $this->partnerId) {
            $partner = Partner::findOrFail($this->partnerId);
            $partner->update($data);
            session()->flash('message', 'Partner updated successfully.');
        } else {
            Partner::create($data);
            session()->flash('message', 'Partner added successfully.');
        }

        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        $this->partnerId = $partner->id;
        $this->name = $partner->name;
        $this->website = $partner->website;
        $this->description = $partner->description;
        $this->partner_type = $partner->partner_type;
        $this->existing_logo = $partner->logo;
        $this->is_active = $partner->is_active;
        $this->order = $partner->order;
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        Partner::find($id)?->delete();
        session()->flash('message', 'Partner deleted successfully.');
    }

    public function toggleActive($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->update(['is_active' => !$partner->is_active]);
    }

    public function resetForm()
    {
        $this->reset([
            'partnerId', 'name', 'logo', 'website', 'description',
            'partner_type', 'existing_logo', 'is_active', 'order', 'isEditMode'
        ]);
        $this->is_active = true;
        $this->order = 0;
        $this->partner_type = Partner::TYPE_PARTNER;
        $this->resetValidation();
    }
}
