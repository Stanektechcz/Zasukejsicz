@extends('layouts.account')

@section('title', 'Fotografie')

@php
    $activeItem = 'photos';
@endphp

@section('account-content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-text-default">
            {{ __('Fotografie') }}
        </h1>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Spravujte své fotografie a profilové obrázky.') }}
        </p>
    </div>

    @livewire('photos-manager')
@endsection