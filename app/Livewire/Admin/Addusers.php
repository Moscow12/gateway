<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class Addusers extends Component
{
    use WithFileUploads;

    public $name = '';
    public $email = '';
    public $role = '';
    public $phone = '';
    public $password = '';
    public $password_confirmation = '';
    public $photos = [];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|exists:roles,name',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ];
    }

    protected $messages = [
        'name.required' => 'Please enter the user\'s name.',
        'email.required' => 'Please enter an email address.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered.',
        'role.required' => 'Please select a role.',
        'role.exists' => 'Please select a valid role.',
        'password.required' => 'Please enter a password.',
        'password.min' => 'Password must be at least 6 characters.',
        'password.confirmed' => 'Passwords do not match.',
        'password_confirmation.required' => 'Please confirm the password.',
        'photos.*.image' => 'Each file must be an image.',
        'photos.*.max' => 'Each image must be less than 2MB.',
    ];

    public function mount()
    {
        // Set default role
        $defaultRole = Role::where('name', 'user')->first();
        $this->role = $defaultRole ? $defaultRole->name : '';
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function removePhoto($index)
    {
        array_splice($this->photos, $index, 1);
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'role', 'phone', 'password', 'password_confirmation', 'photos']);
        $defaultRole = Role::where('name', 'user')->first();
        $this->role = $defaultRole ? $defaultRole->name : '';
        $this->resetValidation();
    }

    public function addUser()
    {
        $this->validate();

        $paths = [];
        foreach ($this->photos as $photo) {
            $paths[] = $photo->store('photos', 'public');
        }

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'phone' => $this->phone,
            'photos' => $paths,
        ]);

        // Assign role using Spatie
        $user->assignRole($this->role);

        session()->flash('success', 'User created successfully!');
        return redirect()->route('users');
    }

    public function render()
    {
        $roles = Role::orderBy('name')->get();

        return view('livewire.admin.addusers', [
            'roles' => $roles,
        ]);
    }
}
