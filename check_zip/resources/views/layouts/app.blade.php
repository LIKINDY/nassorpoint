<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>{{ config('app.name', 'Restaurant POS') }}</title>
    <!-- FontAwesome for Rich Modern Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">
    <meta name="theme-color" content="#1A56DB">

    <!-- Styles / Scripts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @livewireStyles

    <style>
        :root {
            /* Palette: Blue, Green, Gold */
            --primary-blue: #1A56DB;
            --primary-green: #057A55;
            --primary-gold: #FACA15;
            --bg-color: #F3F4F6;
            --text-main: #1F2937;
            --text-muted: #6B7280;
            --surface: #FFFFFF;
            --danger: #E02424;
            
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-full: 9999px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }
        
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Top Navigation */
        .top-nav {
            background-color: var(--primary-blue);
            color: white;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 40;
            box-shadow: var(--shadow-md);
        }

        .nav-brand {
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .icon-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: var(--radius-full);
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        
        .icon-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        .lang-switch {
            font-size: 0.875rem;
            font-weight: 600;
            background: var(--primary-gold);
            color: var(--text-main);
            padding: 4px 8px;
            border-radius: 16px;
            text-decoration: none;
        }

        /* Offline Error Overlay */
        #offline-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: var(--primary-blue);
            color: white;
            z-index: 9999;
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }
        #offline-overlay i {
            font-size: 5rem;
            color: var(--primary-gold);
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-20px);}
            60% {transform: translateY(-10px);}
        }

        .print-only { display: none; }

        @media print {
            @page { margin: 0; size: 58mm auto; }
            html, body { 
                background: white !important; 
                color: black !important; 
                width: 58mm !important; 
                margin: 0 !important;
                padding: 0 !important;
                font-size: 11px !important;
                font-family: monospace, sans-serif !important;
            }
            .no-print, header, nav, .navbar { display: none !important; }
            .print-only { 
                display: block !important; 
                page-break-inside: avoid !important;
                page-break-after: auto !important;
                margin: 0 !important;
                padding: 0 4px !important; /* tiny padding so text doesn't touch the exact edge */
            }
            
            .container, main { 
                max-width: 58mm !important; 
                width: 100% !important;
                margin: 0 !important; 
                padding: 0 !important; 
            }
            
            table { 
                width: 100% !important; 
                border: none !important; 
                font-size: 10px !important; 
            }
            th, td { 
                padding: 2px 0 !important; 
                border: none !important; 
                border-bottom: 1px dashed #000 !important; 
                color: black !important;
            }
            
            .text-center { text-align: center !important; }
            .fw-bold { font-weight: bold !important; }
            .dashed-line { border-bottom: 1px dashed black; margin: 5px 0; }
        }


        /* Container */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 16px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: var(--radius-md);
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-primary {
            background-color: var(--primary-blue);
            color: white;
        }
        .btn-success {
            background-color: var(--primary-green);
            color: white;
        }
        .btn-gold {
            background-color: var(--primary-gold);
            color: var(--text-main);
        }
        .btn:active {
            transform: scale(0.98);
        }

        /* Utilities */
        .d-flex { display: flex; }
        .justify-between { justify-content: space-between; }
        .align-center { align-items: center; }
        .w-100 { width: 100%; }
        .mt-4 { margin-top: 1rem; }
        
        /* Mobile first specifics */
        @media (min-width: 768px) {
            .container { padding: 24px; }
        }
    </style>
</head>
<body>

    <!-- Offline Network Error Screen -->
    <div id="offline-overlay">
        <i class="fa-solid fa-wifi-slash"></i>
        <h2>{{ __('Network Error') }}</h2>
        <p class="mt-4">{{ __('Please check your internet connection.') }}</p>
        <button class="btn btn-gold mt-4" onclick="window.location.reload()">
            <i class="fa-solid fa-rotate-right"></i> {{ __('Retry') }}
        </button>
    </div>

    <!-- Navigation -->
    <nav class="top-nav">
        <div class="nav-brand">
            <i class="fa-solid fa-utensils" style="color: var(--primary-gold);"></i>
            <span>{{ __('Point of Sale') }}</span>
        </div>
        <div class="nav-actions">
            @if(app()->getLocale() == 'en')
                <a href="{{ route('lang.switch', 'sw') }}" class="lang-switch">SW</a>
            @else
                <a href="{{ route('lang.switch', 'en') }}" class="lang-switch">EN</a>
            @endif
            
            <button type="button" onclick="openPrinterSettings()" class="icon-btn" title="{{ __('Printer Settings') }}" style="background: var(--primary-green);">
                <i class="fa-solid fa-print"></i>
            </button>

            <a href="/login" class="icon-btn" title="{{ __('Settings') }}">
                <i class="fa-solid fa-cog"></i>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    @livewireScripts

    <script>
        // Network status handling
        const offlineOverlay = document.getElementById('offline-overlay');
        
        window.addEventListener('offline', () => {
            offlineOverlay.style.display = 'flex';
        });
        
        window.addEventListener('online', () => {
            offlineOverlay.style.display = 'none';
        });

        if (!navigator.onLine) {
            offlineOverlay.style.display = 'flex';
        }
        
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }

        // Kufungua Settings za Printer kwenye Flutter App
        function openPrinterSettings() {
            if (window.AndroidPrinter && window.AndroidPrinter.postMessage) {
                // Tuma amri kwenda Flutter App kufungua Settings Screen
                window.AndroidPrinter.postMessage('OPEN_SETTINGS');
            } else {
                alert('{{ __("Printer settings are only available inside the Android App.") }}');
            }
        }
    </script>
</body>
</html>
