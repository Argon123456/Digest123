<?php

use App\Company;
use App\Contact;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/webhook/', function (Request $request) {
    app('log')->info("Request Captured", $request->all());

    //$email = $_POST['fields']['email']['value'];
    //$formName = $_POST['form']['name'];
    
    $email = $request->input('Email');
    $formName = $request->input('form_name');

    $validator = Validator::make(['email' => $email], [
        'email'=>'required|email'
    ]);
    if (!$validator->valid()) return true;

    if ($formName == 'city') {
        $company = Company::findOrFail(71);
        $list = Subscription::findOrFail(4);
        $name = 'Подписчик City';
    } else {
        $company = Company::findOrFail(70);
        $list = Subscription::findOrFail(3);
        $name = 'Подписчик VDS';
    }
    $contact = new Contact;
    $contact->name = $name;
    $contact->email = $email;
    $contact->company_id = $company->id;
    $contact->save();
    $contact->subscriptions()->attach($list->id);
    return true;
    //return '$request->user()';
});
