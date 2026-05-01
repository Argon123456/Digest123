<?php

namespace App\Http\Controllers;

use App\Digest;
use App\DigestType;
use App\Subscription;
use Illuminate\Http\Request;

class DigestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $digest = new Digest;
        $today = date('j.m.y h:i:s');
        $digest->name = 'Дайджест от ' . $today;
        //$digest->digest_type_id = 1;
        $digest->save();
        return redirect('/digest/'.$digest->id);
        //return view('digest');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Digest  $digest
     * @return \Illuminate\Http\Response
     */
    public function show(Digest $digest)
    {
        $subscriptions = Subscription::all();
        $digestTypes = DigestType::all();
        return view('digest', compact('digest','subscriptions','digestTypes') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Digest  $digest
     * @return \Illuminate\Http\Response
     */
    public function edit(Digest $digest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Digest  $digest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Digest $digest)
    {
        $news = $request->news;
        $digest->name = $request->name;
        $digest->news = $news;
        $digest->digest_type_id = $request->template;
        $digest->status = 'published';
        $digest->save();
        return response(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Digest  $digest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Digest $digest)
    {
        // Удаляем дайджест (SoftDelete)
        $digest->delete();

        // Возвращаем успешный ответ для фронтенда
        return response(200);
    }
    public function json($id)
    {
        $digest = Digest::find($id);
        return response()->json($digest);
    }
}
