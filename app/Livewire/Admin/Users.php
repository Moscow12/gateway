<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class Users extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterRole = '';
    public $filterStatus = '';

    // Edit modal properties
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $userId;
    public $name;
    public $email;
    public $phone;
    public $role;
    public $password;
    public $password_confirmation;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|exists:roles,name',
            'password' => 'nullable|min:6|confirmed',
        ];
    }

    protected $messages = [
        'name.required' => 'Please enter the user\'s name.',
        'email.required' => 'Please enter an email address.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered.',
        'role.required' => 'Please select a role.',
        'password.min' => 'Password must be at least 6 characters.',
        'password.confirmed' => 'Passwords do not match.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterRole()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->roles->first()?->name ?? '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['userId', 'name', 'email', 'phone', 'role', 'password', 'password_confirmation']);
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);

        // Sync role
        $user->syncRoles([$this->role]);

        session()->flash('success', 'User updated successfully!');
        $this->closeEditModal();
    }

    public function toggleActive($id)
    {
        $user = User::findOrFail($id);

        // Prevent deactivating yourself
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot deactivate your own account.');
            return;
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        session()->flash('success', "User {$status} successfully!");
    }

    public function confirmDelete($id)
    {
        $this->userId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $user = User::findOrFail($this->userId);

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            $this->showDeleteModal = false;
            return;
        }

        // Check if user has any related records
        if ($this->userHasRecords($user)) {
            session()->flash('error', 'Cannot delete user. This user has associated records.');
            $this->showDeleteModal = false;
            return;
        }

        // Remove all roles before deleting
        $user->syncRoles([]);
        $user->delete();

        session()->flash('success', 'User deleted successfully!');
        $this->showDeleteModal = false;
        $this->userId = null;
    }

    /**
     * Check if user has any related records that would prevent deletion
     */
    protected function userHasRecords(User $user): bool
    {
        // Check for SMS categories
        if ($user->SmsCategories()->count() > 0) {
            return true;
        }

        // Add more relationship checks here as needed
        // For example:
        // if ($user->invoices()->count() > 0) return true;
        // if ($user->clients()->count() > 0) return true;

        return false;
    }

    public function render()
    {
        $users = User::with('roles')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterRole, function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', $this->filterRole);
                });
            })
            ->when($this->filterStatus !== '', function ($query) {
                $query->where('is_active', $this->filterStatus);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $roles = Role::orderBy('name')->get();

        return view('livewire.admin.users', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
