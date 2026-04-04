@php
    $tab = request('tab', 'overview');
@endphp

<div class="flex space-x-4 border-b">
    <a href="{{ route('dashboard', ['tab' => 'overview']) }}#tabs"
       class="pb-2 {{ $tab === 'overview' ? 'border-b-2 border-blue-500 font-bold' : '' }}">
        概要
    </a>

    <a href="{{ route('dashboard', ['tab' => 'category']) }}#tabs"
       class="pb-2 {{ $tab === 'category' ? 'border-b-2 border-blue-500 font-bold' : '' }}">
        カテゴリ分析
    </a>

    <a href="{{ route('dashboard', ['tab' => 'list']) }}#tabs"
       class="pb-2 {{ $tab === 'list' ? 'border-b-2 border-blue-500 font-bold' : '' }}">
        契約一覧
    </a>
</div>
