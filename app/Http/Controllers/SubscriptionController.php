<?php

namespace App\Http\Controllers;

use App\Contact;
use App\SubscriberList;
use App\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $SubscriberList = SubscriberList::orderBy('created_at', 'desc')->get();
        return view('subscriberList', ['subscriberList' => $SubscriberList]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subscription.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'name'=> 'required|min:1',
            'short'=> 'required|min:1',
        ]);

        $sub = new Subscription();
        $sub->name = $request->name;
        $sub->short = $request->short;
        $sub->save();

        return redirect()->route('home');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubscriberList  $subscriberList
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list = Subscription::with('contacts')->find($id);
        //dd($list);
        return  view('subscription.show', ['list' => $list]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubscriberList  $subscriberList
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        return view('subscription.edit', compact("subscription") );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubscriberList  $subscriberList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        $subscription->name = $request->name;
        $subscription->short = $request->short;
        $subscription->save();

        return redirect()->route('home');
        //return  view('subscription.edit', compact("subscription") );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        // Запрещаем удаление списка с id = 1 (основной список)
        if ($subscription->id == 1) {
            return redirect()->back()->with('error', 'Этот список нельзя удалить');
        }

        // Отвязываем все контакты от этого списка
        $subscription->contacts()->detach();

        // Удаляем сам список
        $subscription->delete();

        return redirect()->route('home')->with('success', 'Список успешно удалён');
    }

    public function json($id)
    {
        $list = Subscription::with('contacts.company')->find($id);

        //$contacts = Contact::with('subscriptions')->where($id);
        //dd($list);
        return $list->contacts;
    }

    public function contacts($id)
    {

        $list = Subscription::findOrFail($id);
        $contacts = Contact::whereDoesntHave('subscriptions',function($query) use ($list){
            $query->where('subscription_id', $list->id);
        })->get();;

        return $contacts;
    }

    public function subscribe(Request $request)
    {
        $id = $request->id;
        $contactIds = $request->keys;
        Subscription::findOrFail($id)->contacts()->syncWithoutDetaching($contactIds);
        return true;
    }

    public function unsubscribe(Request $request)
    {
        $id = $request->id;
        $contactId = $request->contactId;
        Subscription::findOrFail($id)->contacts()->detach($contactId);
        return true;
    }
}
