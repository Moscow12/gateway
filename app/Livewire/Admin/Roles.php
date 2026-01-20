<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Roles extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showDeleteModal = false;
    public $editMode = false;
    public $roleId;
    public $name;
    public $selectedPermissions = [];
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $this->roleId,
            'selectedPermissions' => 'array',
        ];
    }

    protected $messages = [
        'name.required' => 'Please enter a role name.',
        'name.unique' => 'This role name already exists.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['roleId', 'name', 'selectedPermissions', 'editMode']);
        $this->resetValidation();
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $this->roleId = $role->id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $role = Role::findOrFail($this->roleId);
            $role->update(['name' => $this->name]);
            $role->syncPermissions($this->selectedPermissions);
            session()->flash('success', 'Role updated successfully!');
        } else {
            $role = Role::create(['name' => $this->name]);
            $role->syncPermissions($this->selectedPermissions);
            session()->flash('success', 'Role created successfully!');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->roleId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $role = Role::findOrFail($this->roleId);

        // Prevent deleting super-admin role
        if ($role->name === 'super-admin') {
            session()->flash('error', 'Cannot delete the super-admin role.');
            $this->showDeleteModal = false;
            return;
        }

        $role->delete();
        session()->flash('success', 'Role deleted successfully!');
        $this->showDeleteModal = false;
        $this->roleId = null;
    }

    public function render()
    {
        $roles = Role::with('permissions')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(10);

        $permissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            return explode(' ', $permission->name)[1] ?? 'general';
        });

        return view('livewire.admin.roles', [
            'roles' => $roles,
            'permissions' => $permissions,
            'allPermissions' => Permission::orderBy('name')->get(),
        ]);
    }
}
