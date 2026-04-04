@php
    $tab = request('tab', 'overview');
@endphp

<x-app-layout>

<div class="max-w-7xl mx-auto px-4">
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Dash board</h2>

    <a href="{{ route('subscriptions.create') }}"
       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
        ＋ サブスクを追加
    </a>
</div>
    <div class="p-6">
        <div class="max-w-7xl mx-auto px-4">
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
</div>
</x-app-layout>
