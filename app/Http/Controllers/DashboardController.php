<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

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

        $categoryData = $subscriptions
            ->groupBy('category_id')
            ->map(function ($items) {
                return [
                    'total' => $items->sum('monthly_price'),
                    'items' => $items
                ];
            });

        // カテゴリ名も取得
        $allCategories = $subscriptions->first()->category;
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
            'subscriptions',
            'monthlyTotal',
            'yearlyTotal',
            'count',
            'categoryData',
            'topCategories',
            'chartLabels',
            'chartData',
            'chartLabelsWithPrice',
        ));
    }

}
