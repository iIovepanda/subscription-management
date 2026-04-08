<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\UsageFrequency;
use App\Models\Subscription;

class SubscriptionController extends Controller
{

    public function create()
    {
        $categories = Category::all();
        $frequencies = UsageFrequency::all();

        return view('subscriptions.create', compact('categories', 'frequencies'));
    }

    public function store(StoreSubscriptionRequest $request)
    {
        Subscription::create(
            $request->validated() + ['user_id' => auth()->id()]
        );

        return redirect()
            ->route('dashboard', ['tab' => 'list'])
            ->with('success', 'サブスクを登録しました');
    }

    public function destroy($id)
    {
        $subscription = auth()->user()->subscriptions()->findOrFail($id);
        $subscription->delete();

        return redirect()->back()
            ->with('success', '削除しました');
    }

    public function edit($id)
    {
        $subscription = auth()->user()->subscriptions()->findOrFail($id);
        $categories = Category::all();
        $frequencies = UsageFrequency::all();

        return view('subscriptions.edit', compact('subscription', 'categories', 'frequencies'));
    }

    public function update(StoreSubscriptionRequest $request, $id)
    {
        $subscription = auth()->user()->subscriptions()->findOrFail($id);

        $subscription->update(
            $request->validated()
        );

        return redirect()
            ->route('dashboard', ['tab' => 'list'])
            ->with('success', '更新しました');
    }

}
