<?php

namespace App\Livewire\Owner;

use Livewire\Component;
use App\Models\Order;
use App\Models\MenuItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Reports extends Component
{
    public $filter = 'daily'; // daily, weekly, monthly, yearly
    public $menuFilter = '';
    public $menuFilterName = 'All Food Items';
    public $salesData = [];
    public $totalSales = 0;
    public $totalOrders = 0;
    public $menuItems = [];
    public $showAllReports = false;
    public $hasMore = false;

    public function mount()
    {
        $ownerBranchIds = \App\Models\Branch::where('owner_id', \Illuminate\Support\Facades\Auth::id())->pluck('id');
        $this->menuItems = MenuItem::whereIn('branch_id', $ownerBranchIds)->get();
        $this->loadReports();
    }

    public function updatedFilter()
    {
        $this->loadReports();
    }

    public function updatedMenuFilter()
    {
        $this->loadReports();
    }

    public $chartLabels = [];
    public $chartValues = [];

    public function loadReports()
    {
        $ownerBranchIds = \App\Models\Branch::where('owner_id', \Illuminate\Support\Facades\Auth::id())->pluck('id');
        $query = Order::whereIn('branch_id', $ownerBranchIds)->where('status', 'completed');

        if ($this->menuFilter) {
            $menuItem = MenuItem::find($this->menuFilter);
            if ($menuItem) {
                $this->menuFilterName = $menuItem->name;
            } else {
                $this->menuFilterName = 'All Food Items';
            }

            $query->whereHas('items', function($q) {
                $q->where('menu_item_id', $this->menuFilter);
            });
        } else {
            $this->menuFilterName = 'All Food Items';
        }

        if ($this->filter == 'daily') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($this->filter == 'weekly') {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($this->filter == 'monthly') {
            $query->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year);
        } elseif ($this->filter == 'yearly') {
            $query->whereYear('created_at', Carbon::now()->year);
        }

        $allSalesData = $query->orderBy('created_at', 'desc')->get();
        $this->totalSales = $allSalesData->sum('total_amount');
        $this->totalOrders = $allSalesData->count();
        
        $this->hasMore = $allSalesData->count() > 5;

        if ($this->showAllReports) {
            $this->salesData = $allSalesData;
        } else {
            $this->salesData = $allSalesData->take(5);
        }

        $this->generateChartData($allSalesData);
    }

    public function loadMore()
    {
        $this->showAllReports = true;
        $this->loadReports();
    }

    private function generateChartData($allSalesData)
    {
        $this->chartLabels = [];
        $this->chartValues = [];

        // Group data based on filter
        $grouped = collect($allSalesData)->groupBy(function($order) {
            if ($this->filter == 'daily') {
                return Carbon::parse($order->created_at)->format('H:00'); // Hourly
            } elseif ($this->filter == 'weekly') {
                return Carbon::parse($order->created_at)->format('D'); // Day of week
            } elseif ($this->filter == 'monthly') {
                return Carbon::parse($order->created_at)->format('d M'); // Day of month
            } elseif ($this->filter == 'yearly') {
                return Carbon::parse($order->created_at)->format('M'); // Month
            }
        });

        foreach ($grouped as $label => $orders) {
            $this->chartLabels[] = (string) $label;
            $this->chartValues[] = $orders->sum('total_amount');
        }

        // Dispatch browser event to update chart
        $this->dispatch('update-chart', labels: $this->chartLabels, values: $this->chartValues);
    }

    public function render()
    {
        return view('livewire.owner.reports');
    }
}
