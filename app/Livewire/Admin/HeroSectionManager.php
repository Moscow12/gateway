<?php

namespace App\Livewire\Admin;

use App\Models\HeroSection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class HeroSectionManager extends Component
{
    use WithFileUploads, WithPagination;

    public $title, $subtitle, $description;
    public $button_text, $button_link, $button2_text, $button2_link;
    public $image, $background_image, $existing_image, $existing_bg_image;
    public $is_active = true, $order = 0;
    public $heroId;
    public $isEditMode = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'button_text' => 'nullable|string|max:100',
        'button_link' => 'nullable|string|max:255',
        'button2_text' => 'nullable|string|max:100',
        'button2_link' => 'nullable|string|max:255',
        'image' => 'nullable|image|max:2048',
        'background_image' => 'nullable|image|max:4096',
        'is_active' => 'boolean',
        'order' => 'integer|min:0',
    ];

    public function render()
    {
        return view('livewire.admin.hero-section-manager', [
            'heroSections' => HeroSection::ordered()->paginate(10),
        ]);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'button_text' => $this->button_text,
            'button_link' => $this->button_link,
            'button2_text' => $this->button2_text,
            'button2_link' => $this->button2_link,
            'is_active' => $this->is_active,
            'order' => $this->order,
            'added_by' => Auth::id(),
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('hero', 'public');
        }

        if ($this->background_image) {
            $data['background_image'] = $this->background_image->store('hero/backgrounds', 'public');
        }

        if ($this->isEditMode && $this->heroId) {
            $hero = HeroSection::findOrFail($this->heroId);
            $hero->update($data);
            session()->flash('message', 'Hero section updated successfully.');
        } else {
            HeroSection::create($data);
            session()->flash('message', 'Hero section created successfully.');
        }

        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $hero = HeroSection::findOrFail($id);
        $this->heroId = $hero->id;
        $this->title = $hero->title;
        $this->subtitle = $hero->subtitle;
        $this->description = $hero->description;
        $this->button_text = $hero->button_text;
        $this->button_link = $hero->button_link;
        $this->button2_text = $hero->button2_text;
        $this->button2_link = $hero->button2_link;
        $this->existing_image = $hero->image;
        $this->existing_bg_image = $hero->background_image;
        $this->is_active = $hero->is_active;
        $this->order = $hero->order;
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        HeroSection::find($id)?->delete();
        session()->flash('message', 'Hero section deleted successfully.');
    }

    public function toggleActive($id)
    {
        $hero = HeroSection::findOrFail($id);
        $hero->update(['is_active' => !$hero->is_active]);
    }

    public function resetForm()
    {
        $this->reset([
            'heroId', 'title', 'subtitle', 'description',
            'button_text', 'button_link', 'button2_text', 'button2_link',
            'image', 'background_image', 'existing_image', 'existing_bg_image',
            'is_active', 'order', 'isEditMode'
        ]);
        $this->is_active = true;
        $this->order = 0;
        $this->resetValidation();
    }
}
