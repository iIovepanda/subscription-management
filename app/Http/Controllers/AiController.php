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
            ->with('usageFrequency')
            ->get();
        foreach ($subscriptions as $sub) {
            $sub->monthly_price = $sub->billing_cycle === 'yearly'
                ? round($sub->price / 12)
                : $sub->price;
        }
        //$subscriptions = auth()->user()->subscriptions;
        $total = $subscriptions->sum('monthly_price');

        $summaryText = "今月の合計: {$total}円\n\n";

        foreach ($subscriptions as $sub) {
            $name = $sub->name ?? '不明';
            $price = $sub->monthly_price ?? 0;

            $frequency = $sub->usageFrequency?->frequency_name ?? '未設定';

            $summaryText .= "- {$name}: {$price}円 / 利用頻度: {$frequency}\n";
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4.1-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'サブスク管理アドバイザーとして、短く具体的にアドバイスしてください（100文字以内）'
                ],
                [
                    'role' => 'user',
                    'content' => $summaryText
                ]
            ],
        ]);

        $aiMessage = $response['choices'][0]['message']['content'] ?? '取得失敗';

        // 成功時だけ保存
        cache()->put($key, $aiMessage, 3600);

        return response()->json([
            'message' => $aiMessage
        ]);
    }
}
