<?php

namespace App\Livewire\Admin;

use App\Models\AboutContent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AboutContentManager extends Component
{
    use WithFileUploads, WithPagination;

    public $section_type, $title, $content, $image, $icon;
    public $existing_image;
    public $is_active = true, $order = 0;
    public $contentId;
    public $isEditMode = false;
    public $filterType = '';

    protected $rules = [
        'section_type' => 'required|string|max:50',
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048',
        'icon' => 'nullable|string|max:50',
        'is_active' => 'boolean',
        'order' => 'integer|min:0',
    ];

    public function render()
    {
        $query = AboutContent::ordered();

        if ($this->filterType) {
            $query->ofType($this->filterType);
        }

        return view('livewire.admin.about-content-manager', [
            'contents' => $query->paginate(10),
            'sectionTypes' => AboutContent::getTypes(),
        ]);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'section_type' => $this->section_type,
            'title' => $this->title,
            'content' => $this->content,
            'icon' => $this->icon,
            'is_active' => $this->is_active,
            'order' => $this->order,
            'added_by' => Auth::id(),
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('about', 'public');
        }

        if ($this->isEditMode && $this->contentId) {
            $about = AboutContent::findOrFail($this->contentId);
            $about->update($data);
            session()->flash('message', 'Content updated successfully.');
        } else {
            AboutContent::create($data);
            session()->flash('message', 'Content created successfully.');
        }

        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $about = AboutContent::findOrFail($id);
        $this->contentId = $about->id;
        $this->section_type = $about->section_type;
        $this->title = $about->title;
        $this->content = $about->content;
        $this->icon = $about->icon;
        $this->existing_image = $about->image;
        $this->is_active = $about->is_active;
        $this->order = $about->order;
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        AboutContent::find($id)?->delete();
        session()->flash('message', 'Content deleted successfully.');
    }

    public function toggleActive($id)
    {
        $about = AboutContent::findOrFail($id);
        $about->update(['is_active' => !$about->is_active]);
    }

    public function resetForm()
    {
        $this->reset([
            'contentId', 'section_type', 'title', 'content',
            'image', 'icon', 'existing_image', 'is_active', 'order', 'isEditMode'
        ]);
        $this->is_active = true;
        $this->order = 0;
        $this->resetValidation();
    }
}
