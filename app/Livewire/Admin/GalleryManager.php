<?php

namespace App\Livewire\Admin;

use App\Models\WebsiteGallery;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class GalleryManager extends Component
{
    use WithFileUploads, WithPagination;

    public $title, $description, $image, $category;
    public $existing_image;
    public $is_active = true, $order = 0;
    public $galleryId;
    public $isEditMode = false;
    public $filterCategory = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:4096',
        'category' => 'nullable|string|max:50',
        'is_active' => 'boolean',
        'order' => 'integer|min:0',
    ];

    public function render()
    {
        $query = WebsiteGallery::ordered();

        if ($this->filterCategory) {
            $query->ofCategory($this->filterCategory);
        }

        return view('livewire.admin.gallery-manager', [
            'galleries' => $query->paginate(12),
            'categories' => WebsiteGallery::getCategories(),
        ]);
    }

    public function save()
    {
        $rules = $this->rules;
        if (!$this->isEditMode) {
            $rules['image'] = 'required|image|max:4096';
        }
        $this->validate($rules);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'is_active' => $this->is_active,
            'order' => $this->order,
            'added_by' => Auth::id(),
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('gallery', 'public');
        }

        if ($this->isEditMode && $this->galleryId) {
            $gallery = WebsiteGallery::findOrFail($this->galleryId);
            $gallery->update($data);
            session()->flash('message', 'Gallery item updated successfully.');
        } else {
            WebsiteGallery::create($data);
            session()->flash('message', 'Gallery item added successfully.');
        }

        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $gallery = WebsiteGallery::findOrFail($id);
        $this->galleryId = $gallery->id;
        $this->title = $gallery->title;
        $this->description = $gallery->description;
        $this->category = $gallery->category;
        $this->existing_image = $gallery->image;
        $this->is_active = $gallery->is_active;
        $this->order = $gallery->order;
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        WebsiteGallery::find($id)?->delete();
        session()->flash('message', 'Gallery item deleted successfully.');
    }

    public function toggleActive($id)
    {
        $gallery = WebsiteGallery::findOrFail($id);
        $gallery->update(['is_active' => !$gallery->is_active]);
    }

    public function resetForm()
    {
        $this->reset([
            'galleryId', 'title', 'description', 'image',
            'category', 'existing_image', 'is_active', 'order', 'isEditMode'
        ]);
        $this->is_active = true;
        $this->order = 0;
        $this->resetValidation();
    }
}
