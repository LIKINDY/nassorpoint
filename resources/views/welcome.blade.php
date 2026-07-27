<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karibu - {{ config('app.name', 'The Nassor Bistro') }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">
    <meta name="theme-color" content="#1A56DB">
    
    <style>
        :root {
            --primary-gold: #d4af37;
            --primary-blue: #003366;
            --accent-orange: #f26b38;
            --text-dark: #333333;
            --text-light: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        h1, h2, h3, .brand-name {
            font-family: 'Playfair Display', serif;
        }

        /* Hero Section */
        .hero {
            position: relative;
            height: 100vh;
            min-height: 600px;
            background-image: url('{{ asset('images/hero.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--text-light);
            z-index: 1;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 51, 102, 0.7), rgba(0, 0, 0, 0.5));
            z-index: -1;
        }

        .hero-content {
            max-width: 800px;
            padding: 20px;
            animation: fadeIn 1.5s ease-out;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .hero p {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 40px;
        }

        .btn-custom {
            background-color: var(--primary-gold);
            color: var(--text-dark);
            padding: 15px 40px;
            font-size: 1.2rem;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
            text-decoration: none;
            display: inline-block;
        }

        .btn-custom:hover {
            background-color: #fff;
            color: var(--primary-gold);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
        }

        /* Navbar */
        .navbar-custom {
            background: transparent;
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 100;
            padding: 20px 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            color: var(--text-light) !important;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .navbar-brand span {
            color: var(--primary-gold);
        }

        /* Features Section with Watermark */
        .features {
            padding: 100px 0;
            background-color: #fff;
            position: relative;
            z-index: 1;
        }

        .features::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('images/watermark.png') }}');
            background-size: 400px;
            background-repeat: repeat;
            opacity: 0.15;
            z-index: -1;
        }

        .feature-card {
            text-align: center;
            padding: 30px;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--accent-orange);
            margin-bottom: 20px;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            color: var(--primary-blue);
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Footer */
        footer {
            background-color: var(--primary-blue);
            color: var(--text-light);
            text-align: center;
            padding: 30px 0;
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .hero p { font-size: 1.2rem; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-custom">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand brand-name" href="/">The Nassor <span>Bistro</span></a>
            <div class="d-flex align-items-center gap-3">
                @if(app()->getLocale() == 'en')
                    <a href="{{ route('lang.switch', 'sw') }}" class="text-white text-decoration-none fw-bold" style="font-size: 1.1rem;">SW</a>
                @else
                    <a href="{{ route('lang.switch', 'en') }}" class="text-white text-decoration-none fw-bold" style="font-size: 1.1rem;">EN</a>
                @endif
                <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4">{{ __('Login') }}</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>{{ __('Onja Ladha za Mwambao') }}</h1>
            <p>{{ __('Pweza, Ngisi, Samaki, na Ukarimu wa Pwani unaokufanya ujisikie Nyumbani. Karibu upate huduma iliyo bora.') }}</p>
            <a href="{{ route('login') }}" class="btn-custom">
                <i class="fa-solid fa-cash-register me-2"></i> {{ __('Sehemu ya Mauzo (POS)') }}
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="brand-name" style="color: var(--primary-blue); font-size: 2.5rem; font-weight: 700;">{{ __('Huduma Zetu Bora') }}</h2>
                    <p class="text-muted mt-2" style="font-size: 1.1rem; max-width: 600px; margin: 0 auto;">{{ __('Tunakuletea mfumo wa kisasa wa kusimamia mauzo ili uweze kutoa huduma kwa haraka na ufanisi.') }}</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-fish"></i>
                        </div>
                        <h3>{{ __('Chakula Safi') }}</h3>
                        <p>{{ __('Tunazingatia usafi na ubora wa hali ya juu katika maandalizi ya vyakula vyetu vya asili na vya kisasa kutoka baharini.') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <h3>{{ __('Huduma ya Haraka') }}</h3>
                        <p>{{ __('Kupitia mfumo wetu wa POS, wateja wetu hawakai foleni. Malipo na kuagiza chakula hufanyika kwa sekunde chache.') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-face-smile"></i>
                        </div>
                        <h3>{{ __('Ukarimu wa Pwani') }}</h3>
                        <p>{{ __('Tabasamu na mapokezi mazuri ni utamaduni wetu. Tunahakikisha kila mteja anaondoka na furaha na kurudi tena.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'The Nassor Bistro') }} POS System. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            var navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(0, 51, 102, 0.95)';
                navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.3)';
            } else {
                navbar.style.background = 'transparent';
                navbar.style.boxShadow = 'none';
            }
        });
    </script>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>
</body>
</html>
