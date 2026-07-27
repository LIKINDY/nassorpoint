@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-between align-center" style="margin-bottom: 24px;">
        <h2><i class="fa-solid fa-cash-register"></i> {{ __('Point of Sale') }}</h2>
        <div class="d-flex" style="gap: 10px;">
            @hasrole('Super Admin')
                <a href="{{ route('admin.owners') }}" class="btn btn-primary">
                    <i class="fa-solid fa-cog"></i> {{ __('Settings (Admin)') }}
                </a>
            @endhasrole
            @hasrole('Restaurant Owner')
                <a href="{{ route('owner.reports') }}" class="btn btn-primary">
                    <i class="fa-solid fa-cog"></i> {{ __('Settings (Owner)') }}
                </a>
            @endhasrole
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-gold">
                    <i class="fa-solid fa-right-from-bracket"></i> {{ __('Logout') }}
                </button>
            </form>
        </div>
    </div>

    @livewire('pos-terminal')

</div>
@endsection
