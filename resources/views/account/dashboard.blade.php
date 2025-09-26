@extends('layouts.account')

@section('title', __('front.account.dashboard.title'))

@php
    $activeItem = 'dashboard';
@endphp

@section('account-content')
    <div class="mb-8">
        <h1 class="text-4xl font-semibold text-secondary py-6 text-center">
            {{ __('front.account.dashboard.basic_info') }}
        </h1>
        <hr>
    </div>

    @livewire('profile-form')
@endsection

