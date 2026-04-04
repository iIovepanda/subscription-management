<div class="bg-white p-6 rounded-xl shadow">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b">
                <th class="w-1/4 cursor-pointer">サービス名 ▼</th>
                <th>カテゴリ</th>
                <th>月額料金</th>
                <th>支払い</th>
                <th>使用頻度</th>
                <th>次回更新日</th>
                <th>ステータス</th>
                <th>編集</th>
                <th>削除</th>
            </tr>
        </thead>

        <tbody>
            @foreach($subscriptions as $sub)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 font-semibold text-lg truncate max-w-[200px]">
                        {{ $sub->name }}
                    </td>
                    <td>{{ $sub->category->name ?? '-' }}</td>
                    <td>¥{{ number_format($sub->monthly_price) }}</td>
                    <td>{{ $sub->billing_cycle === 'monthly' ? '月額払い' : '年額払い' }}</td>
                    <td>{{ $sub->usageFrequency->frequency_name?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($sub->renewal_date)->format('Y.m.d') }}</td>
                    <td>
                        @if($sub->status === 'active')
                            <span class="px-2 py-1 text-sm bg-green-100 text-green-700 rounded">
                                ● 契約中
                            </span>
                        @else
                            <span class="px-2 py-1 text-sm bg-gray-200 text-gray-600 rounded">
                                ○ 解約済
                            </span>
                        @endif
                    </td>
                    <td class="py-3">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('subscriptions.edit', $sub->id) }}">
                                ✏️
                            </a>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="delete-btn text-red-500 font-semibold" data-id="{{ $sub->id }}">
                            ✕
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- 削除フォーム -->
<form method="POST" id="deleteForm" data-url="{{ url('subscriptions') }}">
    @csrf
    @method('DELETE')
</form>

<!-- モーダル -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow">
        <p class="mb-4">本当に削除しますか？</p>
        <div class="flex justify-end gap-2">
            <button id="cancelBtn" class="px-4 py-2 bg-gray-300 rounded">キャンセル</button>
            <button id="confirmBtn" class="px-4 py-2 bg-red-500 text-white rounded">削除</button>
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
