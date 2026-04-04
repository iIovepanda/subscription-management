<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription;

class UsageFrequency extends Model
{
    //protected $table = 'usage_frequency';

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
