<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\UsageFrequency;

class Subscription extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function usageFrequency()
    {
        return $this->belongsTo(UsageFrequency::class);
    }

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'category_id',
        'usage_frequency_id',
        'billing_cycle',
        'start_date',
        'renewal_date',
        'status',
    ];

    public function getMonthlyPriceAttribute()
    {
        switch ($this->billing_cycle) {
            case 'monthly':
                return $this->price;

            case 'yearly':
                return $this->price / 12;

            default:
                return $this->price;
        }
    }
}
