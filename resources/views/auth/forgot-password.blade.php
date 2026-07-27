<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - {{ config('app.name', 'POS System') }}</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0f172a;
            --primary-gold: #fbbf24;
            --bg-color: #f8fafc;
            --text-color: #334155;
            --radius-md: 8px;
            --radius-lg: 12px;
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .card {
            background: white;
            padding: 40px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            margin-top: 0;
            color: var(--primary-blue);
            font-size: 1.5rem;
            margin-bottom: 24px;
            text-align: center;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: var(--radius-md);
            box-sizing: border-box;
            margin-bottom: 16px;
        }
        .btn {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: var(--radius-md);
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            box-sizing: border-box;
            transition: 0.3s;
            text-align: center;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: var(--radius-md);
            margin-bottom: 16px;
            border: 1px solid #bbf7d0;
        }
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: var(--radius-md);
            margin-bottom: 16px;
            border: 1px solid #fecaca;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>{{ __('Forgot Password?') }}</h2>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 24px;">
            {{ __('Enter your email address and we will send you a password reset link.') }}
        </p>

        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div>
                <label style="display: block; font-weight: 500; margin-bottom: 8px;">{{ __('Email Address') }}</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            
            <button type="submit" class="btn">
                <i class="fa-solid fa-envelope"></i> {{ __('Send Password Reset Link') }}
            </button>
            
            <div style="text-align: center; margin-top: 16px;">
                <a href="{{ route('login') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">
                    <i class="fa-solid fa-arrow-left"></i> {{ __('Back to Login') }}
                </a>
            </div>
        </form>
    </div>
</body>
</html>
