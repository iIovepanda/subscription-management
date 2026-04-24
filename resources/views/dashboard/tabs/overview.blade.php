<h2 class="text-xl font-semibold text-gray-800 mb-6">料金が高いサブスク</h2>

<div class="grid grid-cols-3 gap-6">
@foreach($subscriptions->take(3) as $sub)
    <div class="p-6 bg-white rounded-xl shadow-sm transition-shadow hover:shadow-md">
        <p class="text-sm mb-2">{{ $sub->name }}</p>
        <p class="text-3xl font-bold">¥{{ number_format($sub->monthly_price) }}/月</p>
    </div>
@endforeach
</div>
