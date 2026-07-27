<div>
    <div class="no-print">
        <div class="d-flex justify-between align-center mb-4" style="flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
        <h3><i class="fa-solid fa-chart-line" style="color: var(--primary-green);"></i> {{ __('Sales Reports') }}</h3>
        
        <div class="d-flex" style="gap: 12px; flex-wrap: wrap;">
            <select class="form-control no-print" style="width: auto; padding: 8px 12px; border-radius: var(--radius-md); border: 1px solid #d1d5db;" wire:model.live="menuFilter">
                <option value="">{{ __('All Food Items') }}</option>
                @foreach($menuItems as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            
            <select class="form-control no-print" style="width: auto; padding: 8px 12px; border-radius: var(--radius-md); border: 1px solid #d1d5db;" wire:model.live="filter">
                <option value="daily">{{ __('Today (Daily)') }}</option>
                <option value="weekly">{{ __('This Week (Weekly)') }}</option>
                <option value="monthly">{{ __('This Month (Monthly)') }}</option>
                <option value="yearly">{{ __('This Year (Yearly)') }}</option>
            </select>

            <button onclick="window.print()" class="btn btn-gold no-print"><i class="fa-solid fa-print"></i> {{ __('Print Report') }}</button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: white; padding: 20px; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); border-bottom: 4px solid var(--primary-blue);">
            <div style="color: var(--text-muted); font-size: 0.875rem; font-weight: 600; text-transform: uppercase;">{{ __('Total Revenue') }}</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary-blue); margin-top: 8px;">{{ number_format($totalSales, 2) }} TZS</div>
        </div>
        <div style="background: white; padding: 20px; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); border-bottom: 4px solid var(--primary-green);">
            <div style="color: var(--text-muted); font-size: 0.875rem; font-weight: 600; text-transform: uppercase;">{{ __('Total Orders') }}</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary-green); margin-top: 8px;">{{ $totalOrders }}</div>
        </div>
    </div>

    <!-- Chart -->
    <div class="no-print" style="background: white; padding: 20px; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); margin-bottom: 24px; display: flex; justify-content: center;">
        <div style="width: 100%; max-width: 400px;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Transaction List -->
    <div class="table-responsive" style="background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);">
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
            <thead style="background: var(--bg-color); color: var(--text-muted);">
                <tr>
                    <th style="padding: 12px; text-align: left;">{{ __('Order ID') }}</th>
                    <th style="padding: 12px; text-align: left;">{{ __('Date & Time') }}</th>
                    <th style="padding: 12px; text-align: left;">{{ __('Customer') }}</th>
                    <th style="padding: 12px; text-align: right;">{{ __('Amount') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salesData as $order)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 12px; font-weight: 500;">#{{ $order->id }}</td>
                        <td style="padding: 12px;">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td style="padding: 12px;">{{ $order->customer_name ?? __('Walk-in') }}</td>
                        <td style="padding: 12px; text-align: right; color: var(--primary-green); font-weight: 600;">{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                @endforeach
                @if(count($salesData) == 0)
                    <tr>
                        <td colspan="4" style="padding: 20px; text-align: center; color: var(--text-muted);">{{ __('No sales data for this period.') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        @if($hasMore && !$showAllReports)
            <div style="padding: 12px; text-align: center; border-top: 1px solid #e5e7eb; background: var(--bg-color);">
                <button wire:click="loadMore" class="btn btn-primary" style="padding: 8px 16px; border-radius: 20px;">
                    <i class="fa-solid fa-chevron-down"></i> More
                </button>
            </div>
        @endif
    </div>
    </div> <!-- End no-print -->

    <!-- Print Only Receipt -->
    <div class="print-only">
        <div class="text-center fw-bold" style="font-size: 14px;">{{ __('SALES REPORT') }}</div>
        <div class="text-center fw-bold" style="margin-bottom: 5px; font-size: 1.1rem;">{{ Auth::user()->restaurant_name ?? config('app.name') }}</div>
        <div class="dashed-line"></div>
        <div><strong>{{ __('Date') }}:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
        <div><strong>{{ __('Period') }}:</strong> {{ ucfirst($filter) }}</div>
        <div><strong>{{ __('Item(s)') }}:</strong> {{ $menuFilterName }}</div>
        <div class="dashed-line"></div>
        
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align: left;">{{ __('ID') }}</th>
                    <th style="text-align: left;">{{ __('Date') }}</th>
                    <th style="text-align: right;">{{ __('Amt') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salesData as $order)
                <tr>
                    <td style="padding: 2px 0;">#{{ $order->id }}</td>
                    <td style="padding: 2px 0;">{{ $order->created_at->format('d/m H:i') }}</td>
                    <td style="padding: 2px 0; text-align: right;">{{ number_format($order->total_amount) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="dashed-line"></div>
        <div style="display: flex; justify-content: space-between;">
            <strong>{{ __('TOTAL ORDERS') }}:</strong>
            <span>{{ $totalOrders }}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <strong>{{ __('TOTAL REV (TZS)') }}:</strong>
            <span class="fw-bold">{{ number_format($totalSales) }}</span>
        </div>
        <div class="dashed-line"></div>
        <div class="text-center" style="margin-top: 10px;">--- {{ __('End of Report') }} ---</div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            const ctx = document.getElementById('salesChart').getContext('2d');
            let chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: '{{ __('Total Sales (TZS)') }}',
                        data: @json($chartValues),
                        backgroundColor: [
                            '#1A56DB', '#057A55', '#FACA15', '#E02424', '#8B5CF6', 
                            '#F97316', '#14B8A6', '#EC4899', '#0EA5E9', '#84CC16'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

            Livewire.on('update-chart', (data) => {
                let eventData = data[0];
                chart.data.labels = eventData.labels;
                chart.data.datasets[0].data = eventData.values;
                chart.update();
            });
        });
    </script>
</div>
