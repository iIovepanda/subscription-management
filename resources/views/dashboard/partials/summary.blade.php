<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="p-4 bg-white rounded shadow">
        <p>今月の利用料金</p>
        <p class="text-2xl font-bold">¥{{ number_format($monthlyTotal) }}</p>
    </div>

    <div class="p-4 bg-white rounded shadow">
        <p>年間利用料金</p>
        <p class="text-2xl font-bold">¥{{ number_format($yearlyTotal) }}</p>
    </div>

    <div class="p-4 bg-white rounded shadow">
        <p>契約数</p>
        <p class="text-2xl font-bold">{{ $count }}</p>
    </div>
</div>
