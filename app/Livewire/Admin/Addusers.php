<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Addusers extends Component
{
        use WithFileUploads;
    public $name ='', $email ='', $phone ='', $password ='', $password_confirmation ='', $photo ='';
    public $photos = [];
    protected $rules = [
        'password' => 'required|min:6|confirmed',
        'name' => 'required',
        'email' => 'required|email:unique:users',
        'phone' => 'required',
        'photo' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
    ];

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function addUser()
    {     
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable',
            'photos.*' => 'image|max:2048',
        ]);  
       

         $paths = [];

        foreach ($this->photos as $photo) {
            $paths[] = $photo->store('photos', 'public');
        }

        // dd($this->all());
        
        
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'phone' => $this->phone,
            'photos' => $paths,
        ]);
        $user->save();
        session()->flash('success', 'User created successfully!');
        return redirect()->route('users');
        
    }
   
   
    public function render()
    {
        return view('livewire.admin.addusers');
    }
}
