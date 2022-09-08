<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $balance = User::findOrFail(auth()->id())->balance;
        if (Cache::has('informations')) {
            $informations = Cache::get('informations');
        } else {
            $informations = Information::activeInformations();
            Cache::remember('informations', now()->addDay(), function () use ($informations) {
                return $informations;
            });
        }

        if (auth()->user()->hasSeenModal()) {
            $informations = null;
        }

        return view('home', compact('balance', 'informations'));
    }
}
