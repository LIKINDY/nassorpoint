<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt #{{ $receiptOrder->id }}</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 10px; width: 58mm; color: #000; }
        .text-center { text-align: center; }
        .border-bottom { border-bottom: 1px dashed #000; }
        .border-top { border-top: 1px dashed #000; }
        .mb-10 { margin-bottom: 10px; }
        .pb-10 { padding-bottom: 10px; }
        .mt-10 { margin-top: 10px; }
        .pt-10 { padding-top: 10px; }
        .w-100 { width: 100%; }
        table { border-collapse: collapse; }
        th, td { padding: 4px 0; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="text-center border-bottom pb-10 mb-10">
        <h2 style="font-size: 1.2rem; margin: 0; font-weight: 700;">{{ strtoupper($receiptOrder->branch->owner->restaurant_name ?? config('app.name')) }}</h2>
        <p style="margin: 5px 0 0 0; font-size: 0.875rem;">Order #{{ $receiptOrder->id }}</p>
        <p style="margin: 0; font-size: 0.875rem;">{{ $receiptOrder->created_at->format('d/m/Y H:i') }}</p>
        @if($receiptOrder->customer_name)
            <p style="margin: 5px 0 0 0; font-size: 0.875rem;">Customer: {{ $receiptOrder->customer_name }}</p>
        @endif
    </div>
    
    <table class="w-100" style="font-size: 0.875rem;">
        <thead>
            <tr style="border-bottom: 1px solid #000;">
                <th class="text-left">{{ __('Item') }}</th>
                <th class="text-center">{{ __('Qty') }}</th>
                <th class="text-right">{{ __('Amt') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receiptOrder->items as $item)
                <tr>
                    <td class="text-left">{{ $item->menuItem->name ?? 'Item' }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="border-top mt-10 pt-10 font-bold" style="display: flex; justify-content: space-between;">
        <span>{{ __('TOTAL') }}</span>
        <span>{{ number_format($receiptOrder->total_amount, 2) }}</span>
    </div>
    
    <div class="text-center mt-10" style="font-size: 0.75rem; margin-top: 20px;">
        <p>{{ __('Thank you for your visit!') }}</p>
    </div>
</body>
</html>
