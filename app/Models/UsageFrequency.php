<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription;

class UsageFrequency extends Model
{
    protected $fillable = [];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
