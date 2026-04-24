@php
    $tab = request('tab', 'overview');
@endphp

<x-app-layout>

<div class="max-w-7xl mx-auto px-12 py-12">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">
                Dashboard
            </h2>
        </div>

        <a href="{{ route('subscriptions.create') }}"
           class="btn-primary">
            <x-icons.add class="w-4 h-4 fill-current" />
            <span>サブスクを追加</span>
        </a>
    </div>
    <div class="space-y-6">
        {{-- サマリー（共通） --}}
        @include('dashboard.partials.summary')

        {{-- タブ --}}
        @include('dashboard.partials.tabs')

        {{-- 中身 --}}
        <div class="mt-6">
            @if($tab === 'overview')
                @include('dashboard.tabs.overview')

            @elseif ($tab === 'category')
                @include('dashboard.tabs.category')

            @elseif ($tab === 'list')
                @include('dashboard.tabs.list')
            @endif

    </div>
</div>
</x-app-layout>
