<h2 class="text-xl font-bold mb-4">料金が高いサブスク</h2>

<div class="grid grid-cols-3 gap-4">
@foreach($subscriptions->sortByDesc('price')->take(3) as $sub)
    <div class="p-4 bg-white rounded shadow">
        <p>{{ $sub->name }}</p>
        <p class="text-xl font-bold">¥{{ number_format($sub->monthly_price) }}/月</p>
    </div>
@endforeach
</div>
