<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // サブスク更新日更新
        $expiredSubscriptions = $user->subscriptions()
            ->where('status', 'active')
            ->whereDate('renewal_date', '<=', today())
            ->get();

        foreach ($expiredSubscriptions as $subscription) {
            $subscription->refreshNextBillingDate();
        }

        // サブスク更新日が7日以内の場合
        $today = Carbon::today();
        $limit = Carbon::today()->addDays(7);

        $upcomingSubscriptions = $user->subscriptions()
            ->whereBetween('renewal_date', [$today, $limit])
            ->where('status', 'active')
            ->orderBy('renewal_date', 'asc')
            ->get();

        $subscriptions = $user->subscriptions()
            ->with('category', 'usageFrequency')
            ->get()
            ->map(function ($sub) {
                $sub->monthly_price = $sub->billing_cycle === 'yearly'
                    ? round($sub->price / 12)
                    : $sub->price;

                return $sub;
            })
            ->sortByDesc('monthly_price');

        // 月額合計
        $monthlyTotal = $subscriptions->sum('monthly_price');

        // 年額（12倍）
        $yearlyTotal = $monthlyTotal * 12;

        // 件数
        $count = $subscriptions->count();

        // 前月
        $targetDate = Carbon::now()->subMonth();

        $startOfMonth = $targetDate->copy()->startOfMonth();
        $endOfMonth = $targetDate->copy()->endOfMonth();

        $lastMonthSubscriptions = $user->subscriptions()
            ->where('start_date', '<=', $endOfMonth)
            ->where(function ($query) use ($startOfMonth) {
                $query->where('status', 'active')
                      ->orWhere('renewal_date', '>', $startOfMonth);
            })
            ->get()
            ->map(function ($sub) {
                $sub->monthly_price = $sub->billing_cycle === 'yearly'
                    ? $sub->price / 12
                    : $sub->price;

                return $sub;
            });

        $lastMonthlyTotal = $lastMonthSubscriptions->sum('monthly_price');
        $lastYearlyTotal = $lastMonthlyTotal * 12;
        $lastCount = $lastMonthSubscriptions->count();

        // 差額
        $monthlyDiff = $monthlyTotal - $lastMonthlyTotal;
        $yearlyDiff = $yearlyTotal - $lastYearlyTotal;
        $countDiff = $count - $lastCount;

        // 前月との変化率
        $monthlyRate = $lastMonthlyTotal > 0
            ? round(($monthlyDiff / $lastMonthlyTotal) * 100, 1)
            : 0;
        $yearlyRate = $lastYearlyTotal > 0
            ? round(($yearlyDiff / $lastYearlyTotal) * 100, 1)
            : 0;
        $countRate = $lastCount > 0
            ? round(($countDiff / $lastCount) * 100, 1)
            : 0;

        $categoryData = $subscriptions
            ->groupBy('category_id')
            ->map(function ($items) {
                return [
                    'total' => $items->sum('monthly_price'),
                    'items' => $items
                ];
            });

        // カテゴリ名も取得
        $allCategories = $subscriptions->pluck('category', 'category_id');
        $categoryData = $categoryData->map(function ($data, $categoryId) use ($allCategories) {
            return [
                'name' => $allCategories[$categoryId]->name ?? '未分類',
                'total' => $data['total'],
                'items' => $data['items']
            ];
        });

        // 金額順に並び替え
        $categoryData = $categoryData->sortByDesc('total');

        // Top3
        $topCategories = $categoryData->take(3);

        // チャート
        $chartLabels = $categoryData->pluck('name');
        $chartData = $categoryData->pluck('total');
        $chartLabelsWithPrice = $categoryData
            ->map(function ($cat) {
                return $cat['name'] . ' (¥' . number_format($cat['total']) . ')';
            })
            ->values()
            ->toArray();


        return view('dashboard.index', compact(
            'upcomingSubscriptions',
            'subscriptions',
            'monthlyTotal',
            'yearlyTotal',
            'count',
            'monthlyDiff',
            'yearlyDiff',
            'countDiff',
            'monthlyRate',
            'yearlyRate',
            'countRate',
            'categoryData',
            'topCategories',
            'chartLabels',
            'chartData',
            'chartLabelsWithPrice',
        ));
    }

}
