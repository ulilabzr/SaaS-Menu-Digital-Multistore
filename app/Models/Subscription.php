<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillabele = [
        'user_id',
        'end_date',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function SubscriptionPayments()
    {
        return $this->hasMany(SubscriptionPayment::class);
    }
}
