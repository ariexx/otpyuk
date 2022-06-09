<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class Login extends Component
{
    public $email, $password, $remember;
    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.app')->section('content');
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function login()
    {
        $this->validate();
        $throttleKey = strtolower($this->email) . '|' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5, 1)) {
            $this->addError('email', 'Terlalu banyak request!. Silahkan cobalagi', [
                'seconds' => RateLimiter::availableIn($throttleKey),
            ]);
            return null;
        }

        if (!Auth::attempt($this->only(['email', 'password']), $this->remember)) {
            //limit login attempt
            RateLimiter::hit($throttleKey);
            $this->addError('email', 'Tidak ada data yang cocok dengan email ini.');
            return null;
        }

        return redirect('/home');
    }
}
