<div class="bg-white p-6 rounded-xl shadow-sm">
    <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="sticky top-0 bg-white shadow-sm px-4 py-3 text-sm font-medium text-gray-500 w-1/4 cursor-pointer">サービス名 ▼</th>
                    <th class="sticky top-0 bg-white shadow-sm px-4 py-3 text-sm font-medium text-gray-500">カテゴリ</th>
                    <th class="sticky top-0 bg-white shadow-sm px-4 py-3 text-sm font-medium text-gray-500">月額料金</th>
                    <th class="sticky top-0 bg-white shadow-sm px-4 py-3 text-sm font-medium text-gray-500">支払い</th>
                    <th class="sticky top-0 bg-white shadow-sm px-4 py-3 text-sm font-medium text-gray-500">使用頻度</th>
                    <th class="sticky top-0 bg-white shadow-sm px-4 py-3 text-sm font-medium text-gray-500">次回更新日</th>
                    <th class="sticky top-0 bg-white shadow-sm px-4 py-3 text-sm font-medium text-gray-500">ステータス</th>
                    <th class="sticky top-0 bg-white shadow-sm px-4 py-3 text-sm font-medium text-gray-500">編集</th>
                    <th class="sticky top-0 bg-white shadow-sm px-4 py-3 text-sm font-medium text-gray-500">削除</th>
                </tr>
            </thead>

            <tbody>
                @foreach($subscriptions as $sub)
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4" font-semibold text-lg truncate max-w-[200px]">
                            {{ $sub->name }}
                        </td>
                        <td class="px-4 py-4">{{ $sub->category->name ?? '-' }}</td>
                        <td class="px-4 py-4">¥{{ number_format($sub->monthly_price) }}</td>
                        <td class="px-4 py-4">{{ $sub->billing_cycle === 'monthly' ? '月額払い' : '年額払い' }}</td>
                        <td class="px-4 py-4">{{ $sub->usageFrequency->frequency_name?? '-' }}</td>
                        <td class="px-4 py-4">{{ \Carbon\Carbon::parse($sub->renewal_date)->format('Y.m.d') }}</td>
                        <td class="px-4 py-4">
                            @if($sub->status === 'active')
                                <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-700 rounded-full">
                                    ● 契約中
                                </span>
                            @else
                                <span class="px-3 py-1 text-sm font-medium bg-gray-100 text-gray-600 rounded-full">
                                    ○ 解約済
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('subscriptions.edit', $sub->id) }}" class="p-1">
                                    <x-icons.edit class="w-4 h-4 text-gray-500 hover:text-green-700 transition-colors duration-200" />
                                </a>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <button type="button"
                                class="p-1 delete-btn inline-flex items-center text-gray-400 hover:text-red-500 transition-colors duration-200"
                                data-id="{{ $sub->id }}">
                                <x-icons.bin class="w-4 h-4 fill-current" />
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- 削除フォーム -->
<form method="POST" id="deleteForm" data-url="{{ url('subscriptions') }}">
    @csrf
    @method('DELETE')
</form>

<!-- モーダル -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center">
    <div class="bg-red-50 border border-red-100 p-6 rounded-xl shadow-sm w-full max-w-md">
        <p class="text-lg font-semibold text-gray-800 mb-2">本当に削除しますか？</p>
        <p class="text-sm text-gray-500 mb-6">この操作は取り消せません。</p>
        <div class="flex justify-end gap-3">
            <button id="cancelBtn"
                class="px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                キャンセル
            </button>
            <button id="confirmBtn" class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition-colors">削除</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const modal = document.getElementById('deleteModal');
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const cancelBtn = document.getElementById('cancelBtn');
    const confirmBtn = document.getElementById('confirmBtn');
    const form = document.getElementById('deleteForm');

    let deleteId = null;

    // 削除ボタン押下
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            deleteId = btn.dataset.id;
            modal.classList.remove('hidden');
        });
    });

    // キャンセル
    cancelBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // OK押下
    confirmBtn.addEventListener('click', () => {
        form.action = `${form.dataset.url}/${deleteId}`;
        form.submit();
    });
</script>
@endpush
