<x-app-layout>
    <h1 class="text-2xl font-bold text-center mb-8">
        サブスク登録 / 編集
    </h1>

    <form method="POST" action="/subscriptions" class="max-w-4xl mx-auto">
        @csrf

        <div class="grid grid-cols-2 gap-x-8 gap-y-6">

            <div class="flex flex-col">
                <label class="text-sm mb-1">サービス名</label>
                <input type="text" name="name"
                    class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400"
                    placeholder="例：Netflix">
            </div>

            <div class="flex flex-col">
                <label class="text-sm mb-1">金額</label>
                <input type="number" name="price"
                    class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400"
                    placeholder="例：1000">
            </div>

            <div class="flex flex-col">
                <label class="text-sm mb-1">契約開始日</label>
                <input type="date" name="start_date"
                    class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
            </div>

            <div class="flex flex-col">
                <label class="text-sm mb-1">カテゴリ</label>
                <select name="category_id"
                    class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    <option disabled selected>選択してください</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col">
                <label class="text-sm mb-1">次回更新日</label>
                <input type="date" name="next_payment_date"
                    class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
            </div>

            <div class="flex flex-col">
                <label class="text-sm mb-1">利用頻度</label>
                <select name="usage_frequency_id"
                    class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    <option disabled selected>選択してください</option>
                    @foreach ($frequencies as $freq)
                        <option value="{{ $freq->id }}">
                            {{ $freq->frequency_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col">
                <label class="text-sm mb-1">支払い周期</label>
                <select name="billing_cycle"
                    class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    <option value="monthly">月額払い</option>
                    <option value="yearly">年額払い</option>
                </select>
            </div>

            <div class="flex flex-col">
                <label class="text-sm mb-1">ステータス</label>
                <select name="status"
                    class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    <option value="active">契約中</option>
                    <option value="canceled">解約済</option>
                </select>
            </div>

        </div>

        <div class="text-center mt-8">
            <button type="submit"
                class="bg-gray-700 text-white px-6 py-2 rounded-md hover:bg-gray-800">
                保存
            </button>
        </div>
    </form>
</x-app-layout>
