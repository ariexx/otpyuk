<?php

namespace App\Models;

use App\Models\Rate;
use App\Models\Order;
use App\Models\Operator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'operator_id',
        'rate_id',
        'service_name',
        'provider_price',
        'price',
        'discount',
        'discount_percentage',
        'is_active'
    ];

    protected $hidden = [
        // 'provider_id',
        // 'provider_price'
    ];

    protected $casts = [
        'is_active' => 'string'
    ];

    public function rate()
    {
        return $this->belongsTo(Rate::class);
    }

    public function operator()
    {
        return $this->hasMany(Operator::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
