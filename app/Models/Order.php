<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', //get from model user
        'operator_id', //get from model operator
        'service_id', //get from model service
        'provider_order_id', //get from provider API
        'order_id',
        'phone_number',
        'sms_message',
        'status',
        'start_at',
        'expires_at'
    ];

    protected $casts = [
        'status' => OrderStatusEnum::class,
        'start_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
