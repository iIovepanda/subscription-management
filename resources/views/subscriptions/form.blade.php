<div class="flex justify-end mb-4">
    <a href="{{ route('dashboard', ['tab' => 'list']) }}"
       class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 text-sm shadow-sm">
        ← 一覧に戻る
    </a>
</div>
<form method="POST"
    action="{{ isset($subscription)
        ? route('subscriptions.update', $subscription->id)
        : route('subscriptions.store') }}"
    class="max-w-4xl mx-auto">
    @csrf

    @if(isset($subscription))
        @method('PUT')
    @endif

    <div class="grid grid-cols-2 gap-x-8 gap-y-6">

        <div class="flex flex-col">
            <label class="text-sm mb-1">サービス名</label>
            <input type="text" name="name"
                value="{{ old('name', $subscription->name ?? '') }}"
                class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
        </div>

        <div class="flex flex-col">
            <label class="text-sm mb-1">金額</label>
            <input type="number" name="price"
                value="{{ old('price', $subscription->price ?? '') }}"
                class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
        </div>

        <div class="flex flex-col">
            <label class="text-sm mb-1">契約開始日</label>
            <input type="date" name="start_date"
                value="{{ old('start_date', $subscription->start_date ?? '') }}"
                class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
        </div>

        <div class="flex flex-col">
            <label class="text-sm mb-1">カテゴリ</label>
            <select name="category_id"
                class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
                <option disabled>選択してください</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $subscription->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col">
            <label class="text-sm mb-1">次回更新日</label>
            <input type="date" name="next_payment_date"
                value="{{ old('next_payment_date', $subscription->renewal_date ?? '') }}"
                class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
        </div>

        <div class="flex flex-col">
            <label class="text-sm mb-1">利用頻度</label>
            <select name="usage_frequency_id"
                class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
                <option disabled>選択してください</option>
                @foreach ($frequencies as $freq)
                    <option value="{{ $freq->id }}"
                        {{ old('usage_frequency_id', $subscription->usage_frequency_id ?? '') == $freq->id ? 'selected' : '' }}>
                        {{ $freq->frequency_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col">
            <label class="text-sm mb-1">支払い周期</label>
            <select name="billing_cycle"
                class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
                <option value="monthly"
                    {{ old('billing_cycle', $subscription->billing_cycle ?? '') == 'monthly' ? 'selected' : '' }}>
                    月額払い
                </option>
                <option value="yearly"
                    {{ old('billing_cycle', $subscription->billing_cycle ?? '') == 'yearly' ? 'selected' : '' }}>
                    年額払い
                </option>
            </select>
        </div>

        <div class="flex flex-col">
            <label class="text-sm mb-1">ステータス</label>
            <select name="status"
                class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
                <option value="active"
                    {{ old('status', $subscription->status ?? '') == 'active' ? 'selected' : '' }}>
                    契約中
                </option>
                <option value="canceled"
                    {{ old('status', $subscription->status ?? '') == 'canceled' ? 'selected' : '' }}>
                    解約済
                </option>
            </select>
        </div>

    </div>

    <div class="text-center mt-8">
        <button type="submit"
            class="bg-gray-700 text-white px-6 py-2 rounded-md hover:bg-gray-800">
            {{ isset($subscription) ? '更新' : '保存' }}
        </button>
    </div>
</form>
