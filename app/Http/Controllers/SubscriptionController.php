<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\UsageFrequency;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = auth()->user()
            ->subscriptions()
            ->with(['category'])
            ->get();

        return view('subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $categories = Category::all();
        $frequencies = UsageFrequency::all();

        return view('subscriptions.create', compact('categories', 'frequencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|integer',
            'category_id' => 'required',
            'usage_frequency_id' => 'required|exists:usage_frequencies,id',
            'start_date' => 'required|date',
            'next_payment_date' => 'required|date',
            'billing_cycle' => 'required',
            'status' => 'required',
        ]);

        Subscription::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'usage_frequency_id' => $request->usage_frequency_id,
            'billing_cycle' => $request->billing_cycle,
            'start_date' => $request->start_date,
            'renewal_date' => $request->next_payment_date,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('dashboard', ['tab' => 'list'])
            ->with('success', 'サブスクを登録しました');
    }

    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return redirect()->back()
            ->with('success', '削除しました');
    }

    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id);
        $categories = Category::all();
        $frequencies = UsageFrequency::all();

        return view('subscriptions.edit', compact('subscription', 'categories', 'frequencies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|integer',
            'category_id' => 'required',
            'usage_frequency_id' => 'required|exists:usage_frequencies,id',
            'start_date' => 'required|date',
            'next_payment_date' => 'required|date',
            'billing_cycle' => 'required',
            'status' => 'required',
        ]);

        $subscription = Subscription::findOrFail($id);

        $subscription->update([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'usage_frequency_id' => $request->usage_frequency_id,
            'billing_cycle' => $request->billing_cycle,
            'start_date' => $request->start_date,
            'renewal_date' => $request->next_payment_date,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('dashboard', ['tab' => 'list'])
            ->with('success', '更新しました');
    }

}
