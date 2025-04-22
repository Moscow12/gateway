<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Userprofile extends Component
{
    public $phone='', $email='', $password='', $password_confirmation='';
    public $user;
    protected $rules = [
        'password' => 'required|min:6|confirmed',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required',
    ];
    public function render()
    {
        return view('livewire.admin.userprofile');
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->email = Auth::user()->email;
        $this->phone = Auth::user()->phone;
    }

    public function updateprofile()
    {
        

        $this->validate([
            'phone' => 'required|min:10',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'password' => 'required|min:6|confirmed',
            
        ]);

        $user = User::find(Auth::user()->id);
        $user->update([
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        session()->flash('success', 'User profile updated successfully!');
        // return redirect()->route('userprofile');
    }
}
