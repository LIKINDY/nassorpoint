<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ManageOwners extends Component
{
    public $owners = [];
    public $name = '';
    public $restaurant_name = '';
    public $email = '';
    public $password = '';
    public $showForm = false;

    public function mount()
    {
        $this->loadOwners();
    }

    public function loadOwners()
    {
        $this->owners = User::role('Restaurant Owner')->get();
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public $editingOwnerId = null;

    public function createOwner()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'restaurant_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->editingOwnerId,
            'password' => $this->editingOwnerId ? 'nullable|min:6' : 'required|min:6',
        ]);

        if ($this->editingOwnerId) {
            $owner = User::find($this->editingOwnerId);
            $owner->name = $this->name;
            $owner->restaurant_name = $this->restaurant_name;
            $owner->email = $this->email;
            if ($this->password) {
                $owner->password = Hash::make($this->password);
            }
            $owner->save();
            $this->editingOwnerId = null;
        } else {
            $owner = User::create([
                'name' => $this->name,
                'restaurant_name' => $this->restaurant_name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
            $owner->assignRole('Restaurant Owner');
        }

        $this->resetForm();
        $this->loadOwners();
    }

    public $resettingOwnerId = null;
    public $newPassword = '';

    public function initResetPassword($id)
    {
        $this->resettingOwnerId = $id;
        $this->newPassword = '';
    }

    public function resetPassword()
    {
        $this->validate([
            'newPassword' => 'required|min:6',
        ]);

        $owner = User::find($this->resettingOwnerId);
        $owner->password = Hash::make($this->newPassword);
        $owner->save();

        $this->resettingOwnerId = null;
        $this->newPassword = '';
        
        session()->flash('message', 'Password has been reset successfully!');
    }

    public function cancelReset()
    {
        $this->resettingOwnerId = null;
        $this->newPassword = '';
    }

    public function editOwner($id)
    {
        $owner = User::find($id);
        $this->editingOwnerId = $owner->id;
        $this->name = $owner->name;
        $this->restaurant_name = $owner->restaurant_name;
        $this->email = $owner->email;
        $this->password = '';
        $this->showForm = true;
    }

    public function deleteOwner($id)
    {
        User::find($id)->delete();
        $this->loadOwners();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->restaurant_name = '';
        $this->email = '';
        $this->password = '';
        $this->editingOwnerId = null;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.manage-owners');
    }
}
