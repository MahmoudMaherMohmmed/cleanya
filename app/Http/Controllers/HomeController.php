<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Reservation;

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

    public function index()
    {
        return redirect()->route('login');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $users = User::latest()->limit(5)->get();
        $users_count = User::count();
        $clients = Client::where('type', 0)->latest()->limit(5)->get();
        $clients_count = Client::where('type', 0)->count();
        $representatives = Client::where('type', 1)->latest()->limit(5)->get();
        $representatives_count = Client::where('type', 1)->count();
        $reservations_count = Reservation::count();
        
        return view('dashboard.index', compact('users', 'users_count', 'clients', 'clients_count', 'representatives', 'representatives_count', 'reservations_count'));
    }
}
