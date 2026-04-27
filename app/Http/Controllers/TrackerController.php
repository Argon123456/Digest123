<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\Log;
use Illuminate\Http\Request;
use App\Digest;
use Symfony\Component\Console\Input\Input;

class TrackerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function track(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
            try{
                $log = Log::find($id);
                $log->opened = 1;
                $log->save();
            } catch (\Exception $e) {

            }
        }
        return view('tracker.track');
    }
}
