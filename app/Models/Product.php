<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'user_id', 
        'product_category_id',
        'image',
        'name',
        'description',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this -> belongsTo(User::class);
    }

    public function productCategory()
    {
        return $this -> belongsTo(ProductCategory::class);
    }
        public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public static function boot(){
        parent::boot();

        static::creating(function ($model) {
            if(Auth::user()->role === 'store') {
                $model->user_id = Auth::id();
            }

            
        });

        static::updating(function ($model) {
            if(Auth::user()->role === 'store') {
                $model->user_id = Auth::id();
            }

        });
    }
}
