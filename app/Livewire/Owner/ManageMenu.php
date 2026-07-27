<?php

namespace App\Livewire\Owner;

use Livewire\Component;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Auth;

class ManageMenu extends Component
{
    public $categories = [];
    public $menuItems = [];
    
    // Category Form
    public $showCategoryForm = false;
    public $categoryName = '';
    
    // Menu Item Form
    public $showMenuForm = false;
    public $menuName = '';
    public $menuPrice = '';
    public $menuCategoryId = '';
    public $menuDetails = '';

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $branchIds = \App\Models\Branch::where('owner_id', Auth::id())->pluck('id');
        $this->categories = Category::whereIn('branch_id', $branchIds)->get();
        $this->menuItems = MenuItem::whereIn('branch_id', $branchIds)->with('category')->get();
    }

    public function toggleCategoryForm()
    {
        $this->showCategoryForm = !$this->showCategoryForm;
    }

    public function toggleMenuForm()
    {
        $this->showMenuForm = !$this->showMenuForm;
    }

    public function createCategory()
    {
        $this->validate([
            'categoryName' => 'required|string|max:255',
        ]);

        $branchId = \App\Models\Branch::where('owner_id', Auth::id())->value('id') ?? 1;

        Category::create([
            'name' => $this->categoryName,
            'branch_id' => $branchId
        ]);

        $this->categoryName = '';
        $this->showCategoryForm = false;
        $this->loadData();
    }

    public $editingMenuId = null;

    public function createMenuItem()
    {
        $this->validate([
            'menuName' => 'required|string|max:255',
            'menuPrice' => 'required|numeric|min:0',
            'menuCategoryId' => 'required|exists:categories,id',
        ]);

        if ($this->editingMenuId) {
            $item = MenuItem::find($this->editingMenuId);
            $item->update([
                'name' => $this->menuName,
                'price' => $this->menuPrice,
                'category_id' => $this->menuCategoryId,
                'details' => $this->menuDetails,
            ]);
            $this->editingMenuId = null;
        } else {
            $branchId = \App\Models\Branch::where('owner_id', Auth::id())->value('id') ?? 1;
            MenuItem::create([
                'name' => $this->menuName,
                'price' => $this->menuPrice,
                'category_id' => $this->menuCategoryId,
                'details' => $this->menuDetails,
                'branch_id' => $branchId
            ]);
        }

        $this->resetMenuForm();
        $this->loadData();
    }

    public function editMenuItem($id)
    {
        $item = MenuItem::find($id);
        $this->editingMenuId = $item->id;
        $this->menuName = $item->name;
        $this->menuPrice = $item->price;
        $this->menuCategoryId = $item->category_id;
        $this->menuDetails = $item->details;
        $this->showMenuForm = true;
    }

    public function deleteMenuItem($id)
    {
        MenuItem::find($id)->delete();
        $this->loadData();
    }

    public function resetMenuForm()
    {
        $this->menuName = '';
        $this->menuPrice = '';
        $this->menuCategoryId = '';
        $this->menuDetails = '';
        $this->editingMenuId = null;
        $this->showMenuForm = false;
    }

    public function render()
    {
        return view('livewire.owner.manage-menu');
    }
}
