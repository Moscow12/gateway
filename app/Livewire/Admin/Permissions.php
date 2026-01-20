<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showDeleteModal = false;
    public $editMode = false;
    public $permissionId;
    public $name;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:permissions,name,' . $this->permissionId,
        ];
    }

    protected $messages = [
        'name.required' => 'Please enter a permission name.',
        'name.unique' => 'This permission name already exists.',
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
        $this->reset(['permissionId', 'name', 'editMode']);
        $this->resetValidation();
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $this->permissionId = $permission->id;
        $this->name = $permission->name;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $permission = Permission::findOrFail($this->permissionId);
            $permission->update(['name' => $this->name]);
            session()->flash('success', 'Permission updated successfully!');
        } else {
            Permission::create(['name' => $this->name]);
            session()->flash('success', 'Permission created successfully!');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->permissionId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $permission = Permission::findOrFail($this->permissionId);
        $permission->delete();
        session()->flash('success', 'Permission deleted successfully!');
        $this->showDeleteModal = false;
        $this->permissionId = null;
    }

    public function render()
    {
        $permissions = Permission::with('roles')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.admin.permissions', [
            'permissions' => $permissions,
        ]);
    }
}
