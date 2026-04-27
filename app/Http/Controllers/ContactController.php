<?php

namespace App\Http\Controllers;

use App\Company;
use App\Contact;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::all();

        return view('contacts.index', ['subscriptions' => $subscriptions]);

        //return view('subscriberList', ['subscriberList' => $SubscriberList]);
    }

    public function all()
    {
        $subscription = Subscription::all();
        $contacts = Contact::orderBy('name')->with('company')->with('subscriptions')->get();

        foreach ($contacts as $c){
            foreach ($subscription as $s){
                $c['sub-' . $s->id] = $c->subscriptions->contains($s);
            }
        }

        return $contacts;
    }

    public function destroy($id)
    {
        Contact::destroy($id);
        return true;
    }

    public function update(Request $request)
    {
        $id = $request->key['id'];
        $values = $request->values;

        $contact = Contact::findOrFail($id);
        if (isset($values['name'])){
            $contact->name = $values['name'];
        }
        if (array_key_exists('position',$values)){
            $contact->position = $values['position'];
        }
        if (isset($values['email'])){
            $validator = Validator::make(['email' => $values['email']], [
                'email'=>'required|email'
            ]);
            if ($validator->valid())
                $contact->email = $values['email'];
        }
        if(isset($values['company'])){
            $company = Company::findOrFail($values['company']['id']);
            $contact->company_id = $company->id;
        }

        $contact->save();
        return true;
    }

    public function create(Request $request)
    {
        //$id = $request->key['id'];
        $values = $request->values;

        $company = Company::findOrFail($values['company']['id']);

        $contact = new Contact;

        $contact->name = $values['name'];
        if (isset($values['position']))
            $contact->position = $values['position'];
        $contact->email = $values['email'];
        $contact->company_id = $company->id;

        $contact->save();
        return true;
    }

    public function webhook(Request $request)
    {
        $values = $request->values;
        $company = Company::findOrFail(71);
        $contact = new Contact;
        $contact->name = 'Подписчик City';
        $contact->email = 'test@test.by';
        $contact->company_id = $company->id;

        $contact->save();
        return true;
    }

}
