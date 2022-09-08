<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $table = 'informations';
    protected $fillable = [
        'title',
        'description',
        'is_active',
    ];


    public static function activeInformations()
    {
        return self::whereIsActive(true)->orderBy('created_at', 'desc')->get();
    }
}
