@php
    $tab = request('tab', 'overview');
@endphp

<div class="flex space-x-6 border-b border-gray-200">
    <a href="{{ route('dashboard', ['tab' => 'overview']) }}#tabs"
       class="px-4 py-3 transition-colors {{ $tab === 'overview' ? 'border-b-2 border-primary font-semibold' : 'text-gray-500 hover:text-gray-700' }}">
        概要
    </a>

    <a href="{{ route('dashboard', ['tab' => 'category']) }}#tabs"
       class="px-4 py-3 transition-colors {{ $tab === 'category' ? 'border-b-2 border-primary font-semibold' : 'text-gray-500 hover:text-gray-700' }}">
        カテゴリ分析
    </a>

    <a href="{{ route('dashboard', ['tab' => 'list']) }}#tabs"
       class="px-4 py-3 transition-colors {{ $tab === 'list' ? 'border-b-2 border-primary font-semibold' : 'text-gray-500 hover:text-gray-700' }}">
        契約一覧
    </a>
</div>
