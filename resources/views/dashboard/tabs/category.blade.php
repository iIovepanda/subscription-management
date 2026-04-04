<h2 class="text-xl font-bold mb-4">カテゴリ別利用料金</h2>

<div class="space-y-4">

    <div class="bg-white p-6 rounded-xl shadow w-full">
        <div class="h-64">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
</div>

<h2 class="text-xl font-bold mt-8 mb-4">カテゴリ別課金額 Top3</h2>

<div class="grid grid-cols-3 gap-4">
@foreach($topCategories as $cat)
    <div class="p-4 bg-white rounded shadow">
        <p class="font-bold">{{ $cat['name'] }}</p>
        <p class="text-xl font-bold">¥{{ number_format($cat['total']) }}/月</p>

        <details class="mt-2">
            <summary>内訳</summary>
            @foreach($cat['items'] as $item)
                <p class="text-sm">
                    {{ $item->name }}：¥{{ number_format($item->monthly_price) }}
                </p>
            @endforeach
        </details>
    </div>
@endforeach
</div>

@push('scripts')
<script>
const ctx = document.getElementById('categoryChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($chartLabelsWithPrice),
        datasets: [{
            label: '月額利用料',
            data: @json($chartData),
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 16,
                    boxWidth: 12,
                    font: {
                        size: 12
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return '¥' + context.raw.toLocaleString();
                    }
                }
            }
        },

        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '¥' + value.toLocaleString();
                    }
                }
            }
        },
        //indexAxis: 'y',
    }
});
</script>
@endpush
