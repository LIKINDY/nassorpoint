<div class="pos-container d-flex" style="flex-wrap: wrap; gap: 20px;">
    <style>
        .pos-menu { flex: 1; min-width: 300px; }
        .pos-cart { width: 100%; max-width: 400px; background: white; border-radius: var(--radius-lg); padding: 16px; box-shadow: var(--shadow-sm); }
        @media (max-width: 768px) {
            .pos-cart { max-width: 100%; }
        }
        
        .cat-btn {
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid var(--primary-blue);
            background: white;
            color: var(--primary-blue);
            cursor: pointer;
            margin-right: 8px;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .cat-btn.active {
            background: var(--primary-blue);
            color: white;
        }
        
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }
        .item-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 16px;
            text-align: center;
            cursor: pointer;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
            border: 2px solid transparent;
        }
        .item-card:hover {
            transform: translateY(-2px);
            border-color: var(--primary-gold);
            box-shadow: var(--shadow-md);
        }
        .item-price { color: var(--primary-green); font-weight: 700; font-size: 1.1rem; margin-top: 8px; }
        
        .cart-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #e5e7eb; }
        .qty-btn { 
            background: var(--primary-blue); 
            color: white; 
            border: none; 
            width: 32px; 
            height: 32px; 
            border-radius: var(--radius-full); 
            cursor: pointer; 
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-sm);
        }
        .qty-btn.minus { background: var(--danger); }
        .checkout-box { margin-top: 20px; background: var(--bg-color); padding: 16px; border-radius: var(--radius-md); }
        .form-control { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: var(--radius-md); margin-bottom: 12px; }
        
        /* Receipt Printing */
        .receipt-modal { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 100; }
        .receipt-content { background: white; padding: 20px; border-radius: var(--radius-lg); width: 320px; max-height: 90vh; overflow-y: auto; }
        
        @media print {
            body * { visibility: hidden; }
            .receipt-content, .receipt-content * { visibility: visible; }
            .receipt-content { position: absolute; left: 0; top: 0; width: 58mm; margin: 0; padding: 0; box-shadow: none; }
            .no-print { display: none !important; }
        }
    </style>

    <!-- Menu Section -->
    <div class="pos-menu">
        <div class="categories mb-4">
            <button class="cat-btn {{ $selectedCategory == null ? 'active' : '' }}" wire:click="selectCategory(null)">
                {{ __('All') }}
            </button>
            @foreach($categories as $cat)
                <button class="cat-btn {{ $selectedCategory == $cat->id ? 'active' : '' }}" wire:click="selectCategory({{ $cat->id }})">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>

        <div class="items-grid">
            @foreach($menuItems as $item)
                <div class="item-card" wire:click="addToCart({{ $item->id }})">
                    <i class="fa-solid fa-hamburger" style="font-size: 2rem; color: var(--primary-blue); margin-bottom: 8px;"></i>
                    <div style="font-weight: 600;">{{ $item->name }}</div>
                    <div class="item-price">{{ number_format($item->price, 2) }} TZS</div>
                </div>
            @endforeach
            @if(count($menuItems) == 0)
                <p>{{ __('No items found') }}</p>
            @endif
        </div>
    </div>

    <!-- Cart Section -->
    <div class="pos-cart">
        <h3 style="margin-bottom: 16px;"><i class="fa-solid fa-cart-shopping" style="color: var(--primary-green);"></i> {{ __('Cart') }}</h3>
        
        <div class="cart-items" style="max-height: 300px; overflow-y: auto;">
            @foreach($cart as $index => $item)
                <div class="cart-item">
                    <div style="flex: 1;">
                        <div style="font-weight: 600;">{{ $item['name'] }}</div>
                        <div style="color: var(--text-muted); font-size: 0.875rem;">{{ number_format($item['price'], 2) }}</div>
                    </div>
                    <div class="d-flex align-center" style="gap: 8px;">
                        <button class="qty-btn minus" wire:click="updateQuantity({{ $index }}, 'decrease')"><i class="fa-solid fa-minus"></i></button>
                        <span style="font-size: 1.1rem; font-weight: 600; width: 24px; text-align: center;">{{ $item['quantity'] }}</span>
                        <button class="qty-btn" wire:click="updateQuantity({{ $index }}, 'increase')"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
            @endforeach
            @if(empty($cart))
                <div style="text-align: center; color: var(--text-muted); padding: 20px 0;">
                    <i class="fa-solid fa-basket-shopping" style="font-size: 2rem; margin-bottom: 8px;"></i>
                    <p>{{ __('Cart is empty') }}</p>
                </div>
            @endif
        </div>

        <div class="checkout-box">
            <div class="d-flex justify-between" style="font-size: 1.25rem; font-weight: 700; margin-bottom: 16px;">
                <span>{{ __('Total') }}:</span>
                <span style="color: var(--primary-green);">{{ number_format($total, 2) }} TZS</span>
            </div>
            
            <input type="text" class="form-control" placeholder="{{ __('Customer Name') }}" wire:model="customerName">
            <input type="text" class="form-control" placeholder="{{ __('Customer Phone') }}" wire:model="customerPhone">
            
            <button class="btn btn-primary w-100" 
                    style="padding: 12px; font-size: 1.1rem;" 
                    wire:click="confirmOrder" 
                    @click="setTimeout(() => { window.print() }, 1200)"
                    @if(empty($cart)) disabled @endif>
                <i class="fa-solid fa-check-circle"></i> {{ __('Confirm Order') }}
            </button>
        </div>
    </div>

    <!-- Receipt Modal -->
    @if($receiptOrder)
        <div class="receipt-modal">
            <!-- Tumeongeza wire:ignore ili Livewire isiguse kabisa eneo hili -->
            <div class="receipt-content" wire:ignore>
                
                <!-- BUTTON HII HAITAHARIBIWA NA LIVEWIRE TENA -->
                <button type="button" 
                        class="no-print" 
                        onclick="try { window.print(); } catch(e) { alert(e.message); }" 
                        style="width:100%; padding:15px; background:red; color:white; font-weight:bold; margin-bottom:15px; border:none; border-radius:5px; font-size:16px;">
                    MASHINE: BONYEZA HAPA UPPRINTE
                </button>

                <div style="text-align: center; border-bottom: 1px dashed #000; padding-bottom: 10px; margin-bottom: 10px;">
                    <h2 style="font-size: 1.2rem; margin: 0; font-weight: 700;">{{ strtoupper(Auth::user()->branch->owner->restaurant_name ?? config('app.name')) }}</h2>
                    <p style="margin: 5px 0 0 0; font-size: 0.875rem;">Order #{{ $receiptOrder->id }}</p>
                    <p style="margin: 0; font-size: 0.875rem;">{{ $receiptOrder->created_at->format('d/m/Y H:i') }}</p>
                    @if($receiptOrder->customer_name)
                        <p style="margin: 5px 0 0 0; font-size: 0.875rem;">Customer: {{ $receiptOrder->customer_name }}</p>
                    @endif
                </div>
                
                <table style="width: 100%; font-size: 0.875rem; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #000;">
                            <th style="text-align: left; padding: 4px 0;">{{ __('Item') }}</th>
                            <th style="text-align: center; padding: 4px 0;">{{ __('Qty') }}</th>
                            <th style="text-align: right; padding: 4px 0;">{{ __('Amt') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($receiptOrder->items as $item)
                            <tr>
                                <td style="padding: 4px 0;">{{ $item->menuItem->name ?? 'Item' }}</td>
                                <td style="text-align: center; padding: 4px 0;">{{ $item->quantity }}</td>
                                <td style="text-align: right; padding: 4px 0;">{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div style="border-top: 1px dashed #000; margin-top: 10px; padding-top: 10px; display: flex; justify-content: space-between; font-weight: bold;">
                    <span>{{ __('TOTAL') }}</span>
                    <span>{{ number_format($receiptOrder->total_amount, 2) }}</span>
                </div>
                
                <div style="text-align: center; margin-top: 20px; font-size: 0.75rem;">
                    <p>{{ __('Thank you for your visit!') }}</p>
                </div>
                
                <div class="no-print mt-4 d-flex justify-between" style="gap: 10px;">
                    @php
                        $restaurantName = strtoupper(Auth::user()->branch->owner->restaurant_name ?? config('app.name'));
                        $date = $receiptOrder->created_at->format('d/m/Y H:i');
                        
                        $text = str_pad($restaurantName, 32, " ", STR_PAD_BOTH) . "\n";
                        $text .= "--------------------------------\n";
                        $text .= "Order #: " . $receiptOrder->id . "\n";
                        $text .= "Date: " . $date . "\n";
                        if($receiptOrder->customer_name) {
                            $text .= "Customer: " . substr($receiptOrder->customer_name, 0, 22) . "\n";
                        }
                        $text .= "--------------------------------\n";
                        $text .= str_pad("Item", 14) . str_pad("Qty", 5) . str_pad("Amt", 13, " ", STR_PAD_LEFT) . "\n";
                        $text .= "--------------------------------\n";
                        
                        foreach($receiptOrder->items as $item) {
                            $name = substr($item->menuItem->name ?? 'Item', 0, 13);
                            $qty = $item->quantity;
                            $amt = number_format($item->subtotal, 0);
                            $text .= str_pad($name, 14) . str_pad($qty, 5) . str_pad($amt, 13, " ", STR_PAD_LEFT) . "\n";
                        }
                        
                        $text .= "--------------------------------\n";
                        $text .= str_pad("TOTAL:", 15) . str_pad(number_format($receiptOrder->total_amount, 0) . " TZS", 17, " ", STR_PAD_LEFT) . "\n";
                        $text .= "--------------------------------\n";
                        $text .= str_pad("Thank you for your visit!", 32, " ", STR_PAD_BOTH) . "\n";
                        $text .= "\n\n\n"; 
                        
                        $base64Text = base64_encode($text);
                    @endphp
                    
                    <!-- Button inayotumia onClick ya JavaScript -->
                    <button type="button" onclick="triggerSunmiPrint('{!! $base64Text !!}')" class="btn btn-gold flex-1" style="flex: 1; background: #FFD700; color: #000; font-weight: bold; border-radius: 8px; padding: 10px; border: none; cursor: pointer;">
                        <i class="fa-solid fa-print"></i> {{ __('Print Receipt') }}
                    </button>
                    
                    <button type="button" wire:click="closeReceipt" class="btn flex-1" style="flex: 1; background: #e5e7eb; color: #000; font-weight: bold; border-radius: 8px; padding: 10px; border: none; cursor: pointer;">
                        {{ __('Close') }}
                    </button>
                </div>

                <!-- Script iweke nje kabisa ili isisumbuliwe na Livewire -->
                <script>
                    function triggerSunmiPrint(base64Data) {
                        try {
                            // Angalia kama tupo ndani ya App mpya yenye Sunmi Printer SDK au ile ya zamani
                            if (window.SunmiPrinter && window.SunmiPrinter.postMessage) {
                                window.SunmiPrinter.postMessage(base64Data);
                                return;
                            }
                            
                            // App Mpya ya Flutter itaingiza JavascriptChannel inayoitwa "AndroidPrinter"
                            if (window.AndroidPrinter && window.AndroidPrinter.postMessage) {
                                window.AndroidPrinter.postMessage(base64Data);
                                return; // Tumemaliza, imetumwa kwenye Flutter App!
                            }
                            
                            // Njia ya pili (Kama App haina Sunmi SDK, jaribu kutumia Intent ya RawBT)
                            var url = "intent:base64," + base64Data + "#Intent;scheme=rawbt;package=ru.a402d.rawbtprinter;end;";
                            window.location.assign(url);
                            
                            // Njia ya Tatu: Kama intent itashindwa kufungua app, tumia print ya browser baada ya sekunde 1
                            setTimeout(function() {
                                window.print();
                            }, 1000);
                        } catch (e) {
                            console.error("Print Error: ", e);
                            // Njia mbadala ya mwisho kabisa
                            window.print();
                        }
                    }
                </script>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:init', () => {
        // Hii itasikiliza kama component imemaliza kujenga upya HTML
        Livewire.hook('morph.updated', ({ el, component }) => {
            // Kama modal ya risiti ipo kwenye skrini sasa hivi
            if (document.querySelector('.receipt-modal')) {
                // Kama haijawahi ku-print bado kwenye raundi hii
                if (!window.hasPrintedThisOrder) {
                    window.hasPrintedThisOrder = true;
                    setTimeout(() => {
                        window.print();
                    }, 300);
                }
            } else {
                // Ukurasa ukirudi kawaida, ruhusu risiti ijayo iprintike
                window.hasPrintedThisOrder = false;
            }
        });
    });
</script>
