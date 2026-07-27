@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="btn btn-gold"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
    </div>
    @livewire('admin.manage-owners')
</div>
@endsection
