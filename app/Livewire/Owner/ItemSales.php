<?php

namespace App\Livewire\Owner;

use Livewire\Component;
use App\Models\OrderItem;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemSales extends Component
{
    public $filter = 'daily'; // daily, weekly, monthly, yearly
    public $itemSalesData = [];

    public function mount()
    {
        $this->loadItemSales();
    }

    public function updatedFilter()
    {
        $this->loadItemSales();
    }

    public function loadItemSales()
    {
        $ownerBranchIds = \App\Models\Branch::where('owner_id', Auth::id())->pluck('id');
        
        $query = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->whereIn('orders.branch_id', $ownerBranchIds)
            ->where('orders.status', 'completed')
            ->select(
                'menu_items.name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->groupBy('menu_items.id', 'menu_items.name')
            ->orderBy('total_quantity', 'desc');

        if ($this->filter == 'daily') {
            $query->whereDate('orders.created_at', Carbon::today());
        } elseif ($this->filter == 'weekly') {
            $query->whereBetween('orders.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($this->filter == 'monthly') {
            $query->whereMonth('orders.created_at', Carbon::now()->month)->whereYear('orders.created_at', Carbon::now()->year);
        } elseif ($this->filter == 'yearly') {
            $query->whereYear('orders.created_at', Carbon::now()->year);
        }

        $this->itemSalesData = $query->get()->toArray();
    }

    public function render()
    {
        return view('livewire.owner.item-sales');
    }
}
