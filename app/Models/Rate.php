<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate',
        'profit'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
