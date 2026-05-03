<div class="grid grid-cols-3 gap-6 mb-6">
    <div class="p-6 bg-white rounded-xl shadow-sm">
        <p class="text-sm mb-2">今月の利用料金</p>
        <p class="text-3xl font-bold text-primary-500">¥{{ number_format($monthlyTotal) }}</p>
        <div class="mt-3">
            <x-comparison-badge :diff="$monthlyDiff" prefix="¥" label="前月比" :rate="$monthlyRate" />
        </div>
    </div>

    <div class="p-6 bg-white rounded-xl shadow-sm">
        <p class="text-sm mb-2">年間利用料金</p>
        <p class="text-3xl font-bold text-primary-500">¥{{ number_format($yearlyTotal) }}</p>
        <div class="mt-3">
            <x-comparison-badge :diff="$yearlyDiff" prefix="¥" label="前月比" :rate="$yearlyRate" />
        </div>
    </div>

    <div class="p-6 bg-white rounded-xl shadow-sm">
        <p class="text-sm mb-2">契約数</p>
        <p class="text-3xl font-bold text-gray-900">{{ $count }}</p>
        <div class="mt-3">
            <x-comparison-badge :diff="$countDiff" suffix="件" label="前月比" :rate="$countRate" />
        </div>
    </div>
</div>
