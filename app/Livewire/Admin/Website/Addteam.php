<?php

namespace App\Livewire\Admin\Website;

use App\Models\Teams;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Addteam extends Component
{
    use WithFileUploads;
    public $name = '', $title = '',  $photo;

    public function render()
    {
        return view('livewire.admin.website.addteam');
    }

    public function saveteam()
    {
        $this->validate([
            'name' => 'required',
            'title' => 'required',
            'photo' => 'image|max:2048',
        ]);
        $userId = Auth::id();

        if($this->photo) {
            // Save the image to storage/app/public/team and get its path
            $path = $this->photo->store('team', 'public');
        }

        $team = Teams::create([
            'name' => $this->name,
            'title' => $this->title,
            'user_id' => $userId,
            'photo' => $path,
        ]);

        $team->save();
        session()->flash('success', 'Team created successfully!');
        return redirect()->route('team');
    }
}
