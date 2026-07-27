@extends('layouts.app')

@section('content')
<div class="container d-flex" style="justify-content: center; align-items: center; min-height: 80vh;">
    <div style="background: white; padding: 32px; border-radius: var(--radius-lg); width: 100%; max-width: 400px; box-shadow: var(--shadow-md);">
        <h2 style="text-align: center; color: var(--primary-blue); margin-bottom: 24px;">{{ __('Login') }}</h2>
        
        @if($errors->any())
            <div style="background: #FEE2E2; color: var(--danger); padding: 12px; border-radius: var(--radius-md); margin-bottom: 16px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 500; margin-bottom: 8px;">{{ __('Email Address') }}</label>
                <input type="email" name="email" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: var(--radius-md);" required>
            </div>
            
            <div style="margin-bottom: 24px;">
                <div class="d-flex justify-between" style="margin-bottom: 8px;">
                    <label style="font-weight: 500;">{{ __('Password') }}</label>
                    <a href="{{ route('password.request') }}" style="color: var(--primary-blue); text-decoration: none; font-size: 0.9rem;">{{ __('Forgot Password?') }}</a>
                </div>
                <input type="password" name="password" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: var(--radius-md);" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100" style="padding: 12px; font-size: 1.1rem; margin-bottom: 16px;">
                <i class="fa-solid fa-right-to-bracket"></i> {{ __('Login') }}
            </button>
            
            <div style="text-align: center;">
                <a href="{{ route('home') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">
                    <i class="fa-solid fa-arrow-left"></i> {{ __('Back to Home') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
