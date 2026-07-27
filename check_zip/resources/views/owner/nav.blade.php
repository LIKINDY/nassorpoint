<div class="d-flex mb-4 no-print owner-nav-mobile" style="gap: 10px; flex-wrap: wrap;">
    <a href="{{ route('dashboard') }}" class="btn btn-gold nav-btn"><i class="fa-solid fa-arrow-left"></i> <span>{{ __('POS') }}</span></a>
    <a href="{{ route('owner.reports') }}" class="btn nav-btn {{ request()->routeIs('owner.reports') ? 'btn-primary' : 'btn-outline-primary' }}"><i class="fa-solid fa-chart-line"></i> <span>{{ __('Sales Reports') }}</span></a>
    <a href="{{ route('owner.item_sales') }}" class="btn nav-btn {{ request()->routeIs('owner.item_sales') ? 'btn-primary' : 'btn-outline-primary' }}"><i class="fa-solid fa-list-ul"></i> <span>{{ __('Item Sales') }}</span></a>
    <a href="{{ route('owner.menu') }}" class="btn nav-btn {{ request()->routeIs('owner.menu') ? 'btn-primary' : 'btn-outline-primary' }}"><i class="fa-solid fa-utensils"></i> <span>{{ __('Menu Management') }}</span></a>
    <a href="{{ route('owner.branches') }}" class="btn nav-btn {{ request()->routeIs('owner.branches') ? 'btn-primary' : 'btn-outline-primary' }}"><i class="fa-solid fa-code-branch"></i> <span>{{ __('Branches') }}</span></a>
</div>

<style>
    .btn-outline-primary {
        background: transparent;
        border: 1px solid var(--primary-blue);
        color: var(--primary-blue);
    }
    .btn-outline-primary:hover {
        background: var(--primary-blue);
        color: white;
    }
    
    @media (max-width: 768px) {
        .owner-nav-mobile {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 10px 5px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            margin-bottom: 0 !important;
            justify-content: space-around !important;
            gap: 2px !important;
        }
        
        .owner-nav-mobile .nav-btn {
            flex-direction: column;
            font-size: 0.7rem;
            padding: 8px 2px;
            border: none;
            background: transparent;
            color: var(--text-muted);
            flex: 1;
            text-align: center;
        }
        
        .owner-nav-mobile .nav-btn i {
            font-size: 1.2rem;
            margin-bottom: 4px;
        }
        
        .owner-nav-mobile .btn-primary {
            color: var(--primary-blue) !important;
            background: transparent !important;
            font-weight: bold;
        }
        
        .owner-nav-mobile .btn-gold {
            color: var(--primary-gold) !important;
            background: transparent !important;
            font-weight: bold;
        }
        
        /* Ensure the body has padding at the bottom so content isn't hidden by nav */
        body {
            padding-bottom: 70px;
        }
    }
</style>
