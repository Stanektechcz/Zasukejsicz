@extends('layouts.account')

@section('title', 'Statistiky')

@php
    $activeItem = 'statistics';
@endphp

@section('account-content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-text-default">
            {{ __('Statistiky') }}
        </h1>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Sledujte výkon vašeho profilu a interakce.') }}
        </p>
    </div>

    <div class="card p-6">
        <div class="text-center py-12">
            <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Statistiky profilu</h3>
            <p class="text-sm text-gray-500 mb-4">Zde budete moci sledovat výkon vašeho profilu a statistiky návštěvnosti.</p>
            <button class="btn-light">
                Zobrazit detaily
            </button>
        </div>
    </div>
@endsection