@extends('layouts.app')

@section('content')
<!-- Add top padding to account for fixed navbar -->
<div class="container mx-auto pt-38 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <x-member-sidebar :activeItem="$activeItem ?? 'dashboard'" />
        
        <!-- Main Content -->
        <main class="flex-1 px-8">
          
                @yield('member-content')
      
        </main>
    </div>
</div>
@endsection
