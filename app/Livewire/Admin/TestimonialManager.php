<?php

namespace App\Livewire\Admin;

use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TestimonialManager extends Component
{
    use WithFileUploads, WithPagination;

    public $client_name, $client_position, $client_company;
    public $client_image, $existing_image;
    public $testimonial, $rating = 5;
    public $is_active = true, $order = 0;
    public $testimonialId;
    public $isEditMode = false;

    protected $rules = [
        'client_name' => 'required|string|max:255',
        'client_position' => 'nullable|string|max:255',
        'client_company' => 'nullable|string|max:255',
        'client_image' => 'nullable|image|max:2048',
        'testimonial' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
        'is_active' => 'boolean',
        'order' => 'integer|min:0',
    ];

    public function render()
    {
        return view('livewire.admin.testimonial-manager', [
            'testimonials' => Testimonial::ordered()->paginate(10),
        ]);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'client_name' => $this->client_name,
            'client_position' => $this->client_position,
            'client_company' => $this->client_company,
            'testimonial' => $this->testimonial,
            'rating' => $this->rating,
            'is_active' => $this->is_active,
            'order' => $this->order,
            'added_by' => Auth::id(),
        ];

        if ($this->client_image) {
            $data['client_image'] = $this->client_image->store('testimonials', 'public');
        }

        if ($this->isEditMode && $this->testimonialId) {
            $item = Testimonial::findOrFail($this->testimonialId);
            $item->update($data);
            session()->flash('message', 'Testimonial updated successfully.');
        } else {
            Testimonial::create($data);
            session()->flash('message', 'Testimonial added successfully.');
        }

        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $item = Testimonial::findOrFail($id);
        $this->testimonialId = $item->id;
        $this->client_name = $item->client_name;
        $this->client_position = $item->client_position;
        $this->client_company = $item->client_company;
        $this->testimonial = $item->testimonial;
        $this->rating = $item->rating;
        $this->existing_image = $item->client_image;
        $this->is_active = $item->is_active;
        $this->order = $item->order;
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        Testimonial::find($id)?->delete();
        session()->flash('message', 'Testimonial deleted successfully.');
    }

    public function toggleActive($id)
    {
        $item = Testimonial::findOrFail($id);
        $item->update(['is_active' => !$item->is_active]);
    }

    public function resetForm()
    {
        $this->reset([
            'testimonialId', 'client_name', 'client_position', 'client_company',
            'client_image', 'existing_image', 'testimonial', 'rating',
            'is_active', 'order', 'isEditMode'
        ]);
        $this->is_active = true;
        $this->order = 0;
        $this->rating = 5;
        $this->resetValidation();
    }
}
