<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'deposit_method_id',
        'invoice_id', //from tripay or another merchant
        'payment_method', //from tripay
        'total',
        'fee',
        'status'
    ];

    protected $hidden = [
        'invoice_id',
        'user_id',
        'deposit_method_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function depositMethod()
    {
        return $this->belongsTo(DepositMethod::class);
    }
}
