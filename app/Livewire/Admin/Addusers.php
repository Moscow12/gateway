<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Addusers extends Component
{
    public $name ='', $email ='', $phone ='', $password ='', $password_confirmation ='';

    protected $rules = [
        'password' => 'required|min:6|confirmed',
        'name' => 'required',
        'email' => 'required|email:unique:users',
        'phone' => 'required',
    ];

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function addUser()
    {       
        $this->validate();
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'phone' => $this->phone,
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
