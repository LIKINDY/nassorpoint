<?php

namespace App\Livewire\Owner;

use Livewire\Component;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class ManageBranches extends Component
{
    public $branches = [];
    public $showForm = false;
    public $name = '';
    public $address = '';

    public function mount()
    {
        $this->loadBranches();
    }

    public function loadBranches()
    {
        $this->branches = Branch::where('owner_id', Auth::id())->get();
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public $editingBranchId = null;

    public function createBranch()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        if ($this->editingBranchId) {
            $branch = Branch::find($this->editingBranchId);
            $branch->update([
                'name' => $this->name,
                'address' => $this->address,
            ]);
            $this->editingBranchId = null;
        } else {
            Branch::create([
                'name' => $this->name,
                'address' => $this->address,
                'owner_id' => Auth::id() ?? 1,
            ]);
        }

        $this->resetForm();
        $this->loadBranches();
    }

    public function editBranch($id)
    {
        $branch = Branch::find($id);
        $this->editingBranchId = $branch->id;
        $this->name = $branch->name;
        $this->address = $branch->address;
        $this->showForm = true;
    }

    public function deleteBranch($id)
    {
        Branch::find($id)->delete();
        $this->loadBranches();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->address = '';
        $this->editingBranchId = null;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.owner.manage-branches');
    }
}
