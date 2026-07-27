@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @include('owner.nav')
    @livewire('owner.manage-branches')
</div>
@endsection
