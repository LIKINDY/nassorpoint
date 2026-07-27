<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PosTerminal extends Component
{
    public $categories = [];
    public $menuItems = [];
    public $selectedCategory = null;
    public $search = '';
    
    public $cart = [];
    public $customerName = '';
    public $customerPhone = '';
    public $total = 0;
    
    public $receiptOrder = null;

    public function mount()
    {
        $branchIds = \App\Models\Branch::where('owner_id', Auth::id())->pluck('id');
        $this->categories = Category::whereIn('branch_id', $branchIds)->get();
        $this->loadMenuItems();
    }

    public function loadMenuItems()
    {
        $branchIds = \App\Models\Branch::where('owner_id', Auth::id())->pluck('id');
        $query = MenuItem::whereIn('branch_id', $branchIds);
        
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        $this->menuItems = $query->get();
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->loadMenuItems();
    }

    public function addToCart($itemId)
    {
        $item = MenuItem::find($itemId);
        if (!$item) return;

        $found = false;
        foreach ($this->cart as &$cartItem) {
            if ($cartItem['id'] == $item->id) {
                $cartItem['quantity']++;
                $cartItem['subtotal'] = $cartItem['quantity'] * $cartItem['price'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $this->cart[] = [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => 1,
                'subtotal' => $item->price
            ];
        }

        $this->calculateTotal();
    }
    
    public function updateQuantity($index, $action)
    {
        if ($action == 'increase') {
            $this->cart[$index]['quantity']++;
        } else {
            if ($this->cart[$index]['quantity'] > 1) {
                $this->cart[$index]['quantity']--;
            } else {
                unset($this->cart[$index]);
                $this->cart = array_values($this->cart); // Re-index
            }
        }
        
        if (isset($this->cart[$index])) {
            $this->cart[$index]['subtotal'] = $this->cart[$index]['quantity'] * $this->cart[$index]['price'];
        }
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = array_sum(array_column($this->cart, 'subtotal'));
    }

    public function confirmOrder()
    {
        if (empty($this->cart)) return;

        DB::transaction(function () {
            $branchId = \App\Models\Branch::where('owner_id', \Illuminate\Support\Facades\Auth::id())->value('id') ?? 1;
            $order = Order::create([
                'branch_id' => $branchId,
                'cashier_id' => \Illuminate\Support\Facades\Auth::id() ?? 1,
                'customer_name' => $this->customerName,
                'customer_phone' => $this->customerPhone,
                'total_amount' => $this->total,
                'status' => 'completed',
            ]);

            foreach ($this->cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            $this->receiptOrder = $order->load('items.menuItem');
        });

        // ONGEZA MSTARI HUU CHINI YAKE:
        $this->dispatch('amsha-printer');

        // Reset cart
        $this->cart = [];
        $this->customerName = '';
        $this->customerPhone = '';
        $this->total = 0;
    }

    public function closeReceipt()
    {
        $this->receiptOrder = null;
    }

    public function render()
    {
        return view('livewire.pos-terminal');
    }
}
