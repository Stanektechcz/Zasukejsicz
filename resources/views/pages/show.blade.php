@extends('layouts.app')

@section('title', $page->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 pt-30">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $page->title }}</h1>
    </div>

    <!-- Page Content -->
    <div class="max-w-none">
        @blocks($page->content)
    </div>
</div>

<style>
    /* Simple text-based styling for blocks */
    .prose h1 {
        font-size: 2.25rem;
        font-weight: 700;
        line-height: 2.5rem;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        color: #111827;
    }

    .prose h2 {
        font-size: 1.875rem;
        font-weight: 700;
        line-height: 2.25rem;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        color: #111827;
    }

    .prose h3 {
        font-size: 1.5rem;
        font-weight: 600;
        line-height: 2rem;
        margin-top: 1.25rem;
        margin-bottom: 0.75rem;
        color: #111827;
    }

    .prose h4 {
        font-size: 1.25rem;
        font-weight: 600;
        line-height: 1.75rem;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        color: #111827;
    }

    .prose h5 {
        font-size: 1.125rem;
        font-weight: 600;
        line-height: 1.75rem;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        color: #111827;
    }

    .prose h6 {
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.5rem;
        margin-top: 0.75rem;
        margin-bottom: 0.5rem;
        color: #111827;
    }

    .prose p {
        font-size: 1.125rem;
        line-height: 1.75rem;
        margin-top: 0.75rem;
        margin-bottom: 0.75rem;
        color: #374151;
    }

    .prose a {
        color: #ec4899;
        text-decoration: underline;
    }

    .prose a:hover {
        color: #db2777;
    }

    .prose strong {
        font-weight: 600;
        color: #111827;
    }

    .prose em {
        font-style: italic;
    }

    .prose ul {
        list-style-type: disc;
        margin-top: 0.75rem;
        margin-bottom: 0.75rem;
        padding-left: 1.625rem;
    }

    .prose ol {
        list-style-type: decimal;
        margin-top: 0.75rem;
        margin-bottom: 0.75rem;
        padding-left: 1.625rem;
    }

    .prose li {
        margin-top: 0.25rem;
        margin-bottom: 0.25rem;
        color: #374151;
    }

    .prose blockquote {
        border-left: 4px solid #ec4899;
        padding-left: 1rem;
        font-style: italic;
        margin-top: 1rem;
        margin-bottom: 1rem;
        color: #6b7280;
    }

    /* Card block styling */
    .prose [data-block-type="card"] {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-top: 1rem;
        margin-bottom: 1rem;
        background-color: #f9fafb;
    }
</style>
@endsection
