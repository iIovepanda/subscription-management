<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm p-8">
    <div class="flex justify-end mb-4">
        <a href="{{ route('dashboard', ['tab' => 'list']) }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-gray-300 bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors duration-200">
            <x-icons.back class="w-4 h-4 fill-current" />
            <span>一覧に戻る</span>
        </a>
    </div>
    <p class="text-sm text-gray-500 mb-6">
        <span class="text-rose-500">*</span> は必須項目です
    </p>
    <form method="POST"
        action="{{ isset($subscription)
            ? route('subscriptions.update', $subscription->id)
            : route('subscriptions.store') }}">
        @csrf

        @if(isset($subscription))
            @method('PUT')
        @endif

        <div class="grid grid-cols-2 gap-x-8 gap-y-6">

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-500 mb-2">サービス名<span class="ml-1 text-red-500">*</span></label>
                <input type="text" name="name"
                    value="{{ old('name', $subscription->name ?? '') }}"
                    class="border rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-500 mb-2">金額<span class="ml-1 text-red-500">*</span></label>
                <input type="number" name="price"
                    value="{{ old('price', $subscription->price ?? '') }}"
                    class="border rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-500 mb-2">契約開始日<span class="ml-1 text-red-500">*</span></label>
                <input type="date" name="start_date"
                    value="{{ old('start_date', $subscription->start_date ?? '') }}"
                    class="border rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-500 mb-2">カテゴリ<span class="ml-1 text-red-500">*</span></label>
                <select name="category_id"
                    class="border rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
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
                <label class="text-sm font-medium text-gray-500 mb-2">次回更新日<span class="ml-1 text-red-500">*</span></label>
                <input type="date" name="renewal_date"
                    value="{{ old('renewal_date', $subscription->renewal_date ?? '') }}"
                    class="border rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-500 mb-2">利用頻度<span class="ml-1 text-red-500">*</span></label>
                <select name="usage_frequency_id"
                    class="border rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
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
                <label class="text-sm font-medium text-gray-500 mb-2">支払い周期<span class="ml-1 text-red-500">*</span></label>
                <select name="billing_cycle"
                    class="border rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
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
                <label class="text-sm font-medium text-gray-500 mb-2">ステータス<span class="ml-1 text-red-500">*</span></label>
                <select name="status"
                    class="border rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
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

        <div class="flex justify-end mt-10">
            <button type="submit" class="btn-primary">
                {{ isset($subscription) ? '更新' : '保存' }}
            </button>
        </div>
    </form>
</div>
