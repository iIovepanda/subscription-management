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

<div id="modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">

    <!-- カード -->
    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-6">

        <!-- ヘッダー -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">
                更新が近いサブスク
            </h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                ✕
            </button>
        </div>

        <!-- リスト -->
        <div class="space-y-3 max-h-64 overflow-y-auto">
            @foreach($upcomingSubscriptions as $sub)
                @php
                    $days = \Carbon\Carbon::today()->diffInDays($sub->renewal_date);
                @endphp

                <div class="flex justify-between items-center p-3 rounded-lg border hover:bg-gray-50 transition">

                    <div>
                        <p class="font-medium text-gray-800">
                            {{ $sub->name }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($sub->renewal_date)->format('Y/m/d') }}
                        </p>
                    </div>

                    <!-- 日数バッジ -->
                    <span class="
                        text-xs font-semibold px-2 py-1 rounded-full
                        {{ $days === 0 ? 'bg-red-100 text-red-600' : '' }}
                        {{ $days === 1 ? 'bg-orange-100 text-orange-600' : '' }}
                        {{ $days >= 2 ? 'bg-gray-100 text-gray-600' : '' }}
                    ">
                        @if($days === 0)
                            今日
                        @else
                            あと{{ $days }}日
                        @endif
                    </span>

                </div>
            @endforeach
        </div>

        <!-- フッター -->
        <div class="mt-6 text-right">
            <button onclick="closeModal()" class="px-4 py-2 text-sm bg-gray-200 rounded-md hover:bg-gray-300">
                閉じる
            </button>
        </div>

    </div>
</div>

<x-ai-concierge />

<script>
    @if($upcomingSubscriptions->isNotEmpty())
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }
    @endif
    if (!localStorage.getItem('modalClosed')) {
        document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
        localStorage.setItem('modalClosed', 'true');
    }
</script>
</x-app-layout>
