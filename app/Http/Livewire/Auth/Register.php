<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\RateLimiter;

class Register extends Component
{
    public $email, $password, $password_confirmation;
    public function render()
    {
        return view('livewire.auth.register')->extends('layouts.app')->section('content');;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            // 'password_confirmation' => 'required|same:password',
        ];
    }

    public function registerUser()
    {
        $this->validate();
        $throttleKey = request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5, 5)) {
            $this->addError('email', 'Terlalu banyak request!. Silahkan cobalagi', [
                'seconds' => RateLimiter::availableIn($throttleKey),
            ]);
            return null;
        }

        $user = User::create([
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => 'Normal',
            'balance' => '0',
            'apikey' => Str::random(32)
        ]);

        if ($user) RateLimiter::hit($throttleKey);

        // session()->flash('message', 'Berhasil mendaftar. Silahkan tunggu sebentar.');
        Auth::login($user, true);
        // event(new Registered($user));
        return redirect()->to('/home');
    }
}
