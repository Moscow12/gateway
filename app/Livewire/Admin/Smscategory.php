<?php

namespace App\Livewire\Admin;

use App\Models\Smscategories;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Smscategory extends Component
{
    public $smscategoires =[];
    public $categoryname;
    
    public function mount()
    {
        $this->smscategoires = Smscategories::all();
    }
    public function render()
    {
        return view('livewire.admin.smscategory');
    }

    public function addcategory()
    {
        $this->validate([
            'categoryname' => 'required|string|max:255',
        ]);

        Smscategories::create([
            'name' => $this->categoryname,
            'added_by' => Auth::user()->id,
        ]);

        session()->flash('message', 'Category added successfully.');
        $this->reset('categoryname');
    }


    public function delete($id)
    {
        $item = Smscategories::find($id);
        if ($item) {
            $item->delete();
            $this->smscategoires = Smscategories::all(); // Refresh list
        }
    }
}
