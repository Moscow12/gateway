<?php

namespace App\Livewire\Admin;

use App\Models\ServiceType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceTypes extends Component
{
    use WithPagination;

    public $name, $description, $default_duration_months, $is_recurring = false, $base_price, $icon;
    public $serviceTypeId;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $isEditMode = false;

    protected $queryString = ['search'];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'default_duration_months' => 'nullable|integer|min:1|max:120',
            'is_recurring' => 'boolean',
            'base_price' => 'nullable|numeric|min:0',
            'icon' => 'nullable|string|max:50',
        ];
    }

    protected $messages = [
        'name.required' => 'Service type name is required.',
        'default_duration_months.integer' => 'Duration must be a whole number.',
        'base_price.numeric' => 'Base price must be a number.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function editServiceType($id)
    {
        $this->resetForm();
        $this->isEditMode = true;
        $serviceType = ServiceType::findOrFail($id);
        $this->serviceTypeId = $id;
        $this->name = $serviceType->name;
        $this->description = $serviceType->description;
        $this->default_duration_months = $serviceType->default_duration_months;
        $this->is_recurring = $serviceType->is_recurring;
        $this->base_price = $serviceType->base_price;
        $this->icon = $serviceType->icon;
    }

    public function saveServiceType()
    {
        $this->validate();

        if ($this->isEditMode) {
            $serviceType = ServiceType::findOrFail($this->serviceTypeId);
            $serviceType->update([
                'name' => $this->name,
                'description' => $this->description,
                'default_duration_months' => $this->default_duration_months,
                'is_recurring' => $this->is_recurring,
                'base_price' => $this->base_price ?? 0,
                'icon' => $this->icon ?? 'bx-cog',
            ]);
            session()->flash('message', 'Service type updated successfully.');
        } else {
            ServiceType::create([
                'name' => $this->name,
                'description' => $this->description,
                'default_duration_months' => $this->default_duration_months,
                'is_recurring' => $this->is_recurring,
                'base_price' => $this->base_price ?? 0,
                'icon' => $this->icon ?? 'bx-cog',
                'added_by' => Auth::id(),
            ]);
            session()->flash('message', 'Service type added successfully.');
        }

        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function deleteServiceType($id)
    {
        $serviceType = ServiceType::find($id);
        if ($serviceType) {
            $serviceType->delete();
            session()->flash('message', 'Service type deleted successfully.');
        }
    }

    public function resetForm()
    {
        $this->serviceTypeId = null;
        $this->name = '';
        $this->description = '';
        $this->default_duration_months = '';
        $this->is_recurring = false;
        $this->base_price = '';
        $this->icon = '';
        $this->isEditMode = false;
        $this->resetValidation();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = ServiceType::with('user');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        $serviceTypes = $query->paginate(10);

        // Statistics
        $totalServiceTypes = ServiceType::count();
        $recurringTypes = ServiceType::where('is_recurring', true)->count();
        $oneTimeTypes = ServiceType::where('is_recurring', false)->count();

        return view('livewire.admin.service-types', [
            'serviceTypes' => $serviceTypes,
            'totalServiceTypes' => $totalServiceTypes,
            'recurringTypes' => $recurringTypes,
            'oneTimeTypes' => $oneTimeTypes,
        ]);
    }
}
