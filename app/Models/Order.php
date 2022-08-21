<?php

namespace App\Models;

use Carbon\Carbon;
use Laravel\Scout\Searchable;
use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, Searchable;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    #[SearchUsingPrefix(['order_id'])]
    public function toSearchableArray()
    {
        return [
            'order_id' => $this->order_id,
            'sms_message' => $this->sms_message,
            'phone_number' => $this->phone_number,
        ];
    }

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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeStartWasExpired($query)
    {
        return $query->where('start_at', '<', Carbon::parse($this->start_at)->addMinutes(20));
    }

    public static function ratioOrder()
    {
        $date = Carbon::today()->format('m');
        return self::whereMonth('created_at', $date)->count();
    }

    public static function getOrderPerMonth()
    {
        return self::query()->whereMonth('created_at', now()->month)->count('id');
        // return self::query()->where('created_at', '>=', Carbon::now()->subMonth())->count('id');
    }
}
