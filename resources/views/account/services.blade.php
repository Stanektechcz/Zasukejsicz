@extends('layouts.account')

@section('title', 'Služby')

@php
    $activeItem = 'services';
@endphp

@section('account-content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-text-default">
            {{ __('Služby') }}
        </h1>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Spravujte své nabízené služby a ceník.') }}
        </p>
    </div>

    <div class="card p-6">
        <div class="text-center py-12">
            <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Správa služeb</h3>
            <p class="text-sm text-gray-500 mb-4">Zde budete moci spravovat své nabízené služby a ceník.</p>
            <button class="btn-light">
                Přidat službu
            </button>
        </div>
    </div>
@endsection