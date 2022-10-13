<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Information;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\HasName;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'role',
        'balance',
        'apikey'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'apikey',
        'balance'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function canAccessFilament(): bool
    {
        return $this->hasVerifiedEmail() && $this->role === 'Admin';
    }

    public function getFilamentName(): string
    {
        return "{$this->email}";
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function deposit()
    {
        return  $this->hasMany(Deposit::class);
    }

    public static function ratioUser()
    {
        $date = Carbon::today()->format('m');
        return self::whereMonth('created_at', $date)->count();
    }

    public static function getUserPerMonth()
    {
        return self::whereMonth('created_at', now()->month)->count('id');
    }

    public function getBalance($id)
    {
        return $this->findOrFail($id)->balance;
    }

    public function getDetails($apikey)
    {
        return $this->where('apikey', $apikey)->firstOrFail();
    }

    public static function checkApikey($apikey)
    {
        return self::where('apikey', $apikey)->exists();
    }
}
