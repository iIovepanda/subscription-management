<h2 class="text-xl font-semibold text-gray-800 mb-6">カテゴリ別利用料金</h2>
<div class="bg-white rounded-xl shadow-sm p-6 mb-8">
    <div class="h-72 max-w-xl mx-auto">
        <canvas id="categoryChart"></canvas>
    </div>
</div>

<h2 class="text-xl font-semibold text-gray-800 mt-10 mb-6">カテゴリ別課金額 Top3</h2>

<div class="grid grid-cols-3 gap-6 mb-6">
@foreach($topCategories as $cat)
    <div class="p-6 bg-white rounded-xl shadow-sm">
        <p class="text-sm mb-2">{{ $cat['name'] }}</p>
        <p class="text-3xl font-bold text-primary">¥{{ number_format($cat['total']) }}/月</p>

        <details class="mt-2">
            <summary class="text-sm text-gray-600 cursor-pointer hover:text-gray-800">内訳</summary>
            <div class="mt-2 space-y-2 pl-2">
                @foreach($cat['items'] as $item)
                    <p class="text-sm text-gray-600">
                        {{ $item->name }}：¥{{ number_format($item->monthly_price) }}
                    </p>
                @endforeach
            </div>
        </details>
    </div>
@endforeach
</div>

@push('scripts')
<script>
const ctx = document.getElementById('categoryChart');
const primary = getComputedStyle(document.documentElement)
  .getPropertyValue('--color-primary')
  .trim();

const primaryLight = getComputedStyle(document.documentElement)
  .getPropertyValue('--color-primary-light')
  .trim();

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($chartLabelsWithPrice),
        datasets: [{
            label: '月額利用料',
            data: @json($chartData),
            borderRadius: 8,
            backgroundColor: primaryLight,
            hoverBackgroundColor: primary,
            borderColor: primary,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
                top: 8,
                bottom: 8
            }
        },
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 24,
                    boxWidth: 10,
                    color: '#6B7280',
                    font: {
                        size: 14,
                    },
                    usePointStyle: true
                }
            },
            tooltip: {
                enabled: false
            }
        },

        scales: {
            x: {
                ticks: {
                    color: '#6B7280',
                    font: {
                        size: 14,
                    }
                },
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                   color: '#6B7280',
                    font: {
                        size: 14,
                    }
                },
                padding: 8,
                callback: function(value) {
                    return '¥' + value.toLocaleString();
                }
            }
        },
    }
});
</script>
@endpush
