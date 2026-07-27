<div>
    <div class="d-flex justify-between align-center mb-4" style="flex-wrap: wrap; gap: 10px;">
        <h3 style="margin: 0;"><i class="fa-solid fa-list-ul" style="color: var(--primary-gold);"></i> {{ __('Sales by Item') }}</h3>
        
        <div class="d-flex" style="gap: 10px;">
            <select wire:model.live="filter" class="form-control" style="width: auto; margin: 0; padding: 8px;">
                <option value="daily">{{ __('Today') }}</option>
                <option value="weekly">{{ __('This Week') }}</option>
                <option value="monthly">{{ __('This Month') }}</option>
                <option value="yearly">{{ __('This Year') }}</option>
            </select>
        </div>
    </div>

    <div style="background: white; border-radius: var(--radius-lg); padding: 20px; box-shadow: var(--shadow-sm);">
        @if(count($itemSalesData) > 0)
            <div class="table-responsive">
                <table style="width: 100%; text-align: left; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 12px 8px;">{{ __('Item Name') }}</th>
                            <th style="padding: 12px 8px; text-align: center;">{{ __('Quantity Sold') }}</th>
                            <th style="padding: 12px 8px; text-align: right;">{{ __('Total Revenue') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itemSalesData as $data)
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <td style="padding: 12px 8px; font-weight: 500;">{{ $data['name'] }}</td>
                                <td style="padding: 12px 8px; text-align: center;">
                                    <span style="background: var(--bg-color); padding: 4px 10px; border-radius: 20px; font-weight: bold; font-size: 0.9rem;">
                                        {{ $data['total_quantity'] }}
                                    </span>
                                </td>
                                <td style="padding: 12px 8px; text-align: right; color: var(--primary-green); font-weight: bold;">
                                    {{ number_format($data['total_revenue'], 2) }} TZS
                                </td>
                            </tr>
                        @endforeach
                        <tr style="background: #f9fafb; font-weight: bold;">
                            <td style="padding: 12px 8px; text-align: right;">{{ __('TOTAL') }}:</td>
                            <td style="padding: 12px 8px; text-align: center;">{{ array_sum(array_column($itemSalesData, 'total_quantity')) }}</td>
                            <td style="padding: 12px 8px; text-align: right; color: var(--primary-blue);">
                                {{ number_format(array_sum(array_column($itemSalesData, 'total_revenue')), 2) }} TZS
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 40px 0; color: var(--text-muted);">
                <i class="fa-solid fa-receipt" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.5;"></i>
                <p>{{ __('No items sold for this period.') }}</p>
            </div>
        @endif
    </div>
</div>
