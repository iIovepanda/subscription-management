@props(['aiMessage' => null])
<div class="fixed bottom-6 right-6 group">
    <!-- アイコン -->
    <button onclick="openAiModal()"
        class="group fixed bottom-6 right-6 bg-primary text-white p-4 rounded-full shadow-lg hover:bg-primary-dark transition">
        <x-icons.concierge class="w-6 h-6 text-gray-500 hover:text-primary-300 transition-colors duration-200" />
    </button>

    <!-- ツールチップ -->
    <div class="absolute right-14 top-1/2 -translate-y-1/2
        opacity-0 group-hover:opacity-100 transition
        bg-gray-800 text-white text-sm px-3 py-1 rounded whitespace-nowrap">
        AIコンシェルジュのアドバイスを見る
    </div>
</div>

<!-- モーダル -->
<div id="aiModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-lg relative">

        <button onclick="closeAiModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            ✕
        </button>

        <h3 class="text-lg font-semibold mb-4">AIコンシェルジュ</h3>

        <div class="bg-gray-50 p-4 rounded-lg text-gray-700">
            <!-- スピナー -->
            <div id="aiSpinner" class="hidden animate-spin h-5 w-5 border-2 border-gray-300 border-t-primary rounded-full"></div>

            <p id="aiText"></p>
        </div>

    </div>
</div>

@push('scripts')
<script>
async function openAiModal() {
    document.getElementById('aiModal').classList.remove('hidden');

    const textEl = document.getElementById('aiText');
    const spinner = document.getElementById('aiSpinner');
    // ローディング開始
    spinner.classList.remove('hidden');
    textEl.innerText = '考え中...';

    try {
        const res = await fetch('/ai/advice');
        //const data = await res.json();
        const text = await res.text();

        console.log('RAW:', text);

        const data = JSON.parse(text);

        textEl.innerText = data.message;
    } catch (e) {
        textEl.innerText = 'エラーが発生しました';
    } finally {
        // ローディング終了
        spinner.classList.add('hidden');
    }
}

function closeAiModal() {
    document.getElementById('aiModal').classList.add('hidden');
}
</script>
@endpush
