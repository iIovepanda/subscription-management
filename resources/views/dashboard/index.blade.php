@php
    $tab = request('tab', 'overview');
@endphp

<x-app-layout>

<div class="max-w-7xl mx-auto px-12 pt-6 pb-12">
    <div class="flex justify-end items-center mb-6">
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
        <div class="mt-4">
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
