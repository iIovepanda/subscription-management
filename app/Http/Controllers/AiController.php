<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function advice()
    {
        $key = 'ai_' . auth()->id() . '_' . now()->format('Y-m-d-H');

        if (cache()->has($key)) {
            return response()->json([
                'message' => cache()->get($key)
            ]);
        }
        $subscriptions = auth()->user()
            ->subscriptions()
            ->with('category', 'usageFrequency')
            ->where('status', 'active')
            ->get();
        foreach ($subscriptions as $sub) {
            $sub->monthly_price = $sub->billing_cycle === 'yearly'
                ? round($sub->price / 12)
                : $sub->price;
        }
        $total = $subscriptions->sum('monthly_price');

        $summaryText = "今月の合計: {$total}円\n\n";
        $data = [];
        foreach ($subscriptions as $sub) {
            $name = $sub->name ?? '不明';
            $price = $sub->monthly_price ?? 0;

            $frequency = $sub->usageFrequency?->frequency_name ?? '未設定';

            $data[] = [
                'name' => $name,
                'monthly_price' => $price,
                'frequency' => $frequency,
                'category' => $sub->category->name,
            ];
        }
        if (!empty($subscriptions)) {
            $summaryText = json_encode($data, JSON_UNESCAPED_UNICODE);

            $prompt = "あなたは家計改善アドバイザーです。
                ユーザーのサブスクリプション情報を分析し、
                以下の観点でアドバイスしてください。

                - 支出の特徴
                - コスパが低そうなサービス
                - 解約候補
                - 継続価値が高いサービス
                - 支出バランス
                - 改善提案

                厳しすぎず、親しみやすい口調で、
                200文字程度で簡潔にまとめてください。";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4.1-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $prompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $summaryText
                    ]
                ],
            ]);
            $aiMessage = $response['choices'][0]['message']['content'] ?? '取得失敗';

        } else {
            $aiMessage = 'サブスクが未登録です。';
        }



        // 成功時だけ保存
        cache()->put($key, $aiMessage, 3600);

        return response()->json([
            'message' => $aiMessage
        ]);
    }
}
