<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;
use App\Digest;

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
        $digests = Digest::orderBy('created_at', 'desc')->get();
        $subs = Subscription::all();
        return view('home', ['digests' => $digests, 'subscriptions' => $subs]);
    }
}
