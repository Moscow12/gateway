<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ServiceManager extends Component
{
    use WithFileUploads, WithPagination;

    // Form fields
    public $serviceId;
    public $name = '';
    public $slug = '';
    public $short_description = '';
    public $description = '';
    public $icon = 'bx-code-alt';
    public $image;
    public $existing_image;
    public $features = [];
    public $newFeature = '';
    public $price_from;
    public $price_to;
    public $price_unit = 'project';
    public $is_featured = false;
    public $is_active = true;
    public $order = 0;

    // UI State
    public $isEditMode = false;
    public $search = '';
    public $filterStatus = '';

    // Icon options
    public $iconOptions = [
        'bx-code-alt' => 'Code',
        'bx-globe' => 'Web/Globe',
        'bx-mobile-alt' => 'Mobile',
        'bx-cloud' => 'Cloud',
        'bx-data' => 'Data/Database',
        'bx-cog' => 'Settings/Config',
        'bx-support' => 'Support',
        'bx-shield-quarter' => 'Security',
        'bx-server' => 'Server',
        'bx-chip' => 'Hardware',
        'bx-analyse' => 'Analytics',
        'bx-bot' => 'AI/Automation',
        'bx-palette' => 'Design',
        'bx-cart' => 'E-commerce',
        'bx-building' => 'Enterprise',
        'bx-user-voice' => 'Consulting',
    ];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug,' . $this->serviceId,
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048',
            'price_from' => 'nullable|numeric|min:0',
            'price_to' => 'nullable|numeric|min:0',
            'price_unit' => 'required|in:project,hour,month,year',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ];
    }

    public function updatedName()
    {
        if (!$this->isEditMode || empty($this->slug)) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function addFeature()
    {
        if (!empty(trim($this->newFeature))) {
            $this->features[] = trim($this->newFeature);
            $this->newFeature = '';
        }
    }

    public function removeFeature($index)
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => $this->slug ?: Str::slug($this->name),
            'short_description' => $this->short_description,
            'description' => $this->description,
            'icon' => $this->icon,
            'features' => $this->features,
            'price_from' => $this->price_from,
            'price_to' => $this->price_to,
            'price_unit' => $this->price_unit,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'order' => $this->order,
        ];

        if ($this->image) {
            if ($this->existing_image) {
                Storage::disk('public')->delete($this->existing_image);
            }
            $data['image'] = $this->image->store('services', 'public');
        }

        if ($this->isEditMode) {
            $service = Service::find($this->serviceId);
            $service->update($data);
            session()->flash('message', 'Service updated successfully.');
        } else {
            $data['added_by'] = Auth::id();
            Service::create($data);
            session()->flash('message', 'Service created successfully.');
        }

        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);

        $this->serviceId = $service->id;
        $this->name = $service->name;
        $this->slug = $service->slug;
        $this->short_description = $service->short_description;
        $this->description = $service->description;
        $this->icon = $service->icon ?? 'bx-code-alt';
        $this->existing_image = $service->image;
        $this->features = $service->features ?? [];
        $this->price_from = $service->price_from;
        $this->price_to = $service->price_to;
        $this->price_unit = $service->price_unit ?? 'project';
        $this->is_featured = $service->is_featured;
        $this->is_active = $service->is_active;
        $this->order = $service->order;
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        $service = Service::findOrFail($id);

        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();
        session()->flash('message', 'Service deleted successfully.');
    }

    public function toggleActive($id)
    {
        $service = Service::findOrFail($id);
        $service->update(['is_active' => !$service->is_active]);
    }

    public function toggleFeatured($id)
    {
        $service = Service::findOrFail($id);
        $service->update(['is_featured' => !$service->is_featured]);
    }

    public function resetForm()
    {
        $this->reset([
            'serviceId', 'name', 'slug', 'short_description', 'description',
            'image', 'existing_image', 'features', 'newFeature',
            'price_from', 'price_to', 'is_featured', 'order'
        ]);
        $this->icon = 'bx-code-alt';
        $this->price_unit = 'project';
        $this->is_active = true;
        $this->isEditMode = false;
    }

    public function render()
    {
        $query = Service::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('short_description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        } elseif ($this->filterStatus === 'featured') {
            $query->where('is_featured', true);
        }

        $services = $query->ordered()->paginate(10);

        return view('livewire.admin.service-manager', [
            'services' => $services,
        ]);
    }
}
