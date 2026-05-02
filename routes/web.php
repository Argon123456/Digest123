<?php

use App\Subscription;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/digest/{id}', function () {
    return view('digest');
})->middleware('auth');*/

Route::resource('digest', 'DigestController')->only([
    'create', 'show', 'update', 'destroy'
])->middleware('auth');
Route::get('/digest/{id}/json', 'DigestController@json')->middleware('auth');

Auth::routes();

Route::get('/', 'HomeController@index')->middleware('auth')->name('home');

Route::get('/map', function (){

    $faker = Faker\Factory::create('ru_RU');

    \App\Contact::all()->each(function ($user) use ($faker) {
        $user->update([
            'name'  => $faker->name,
            'email' => $faker->unique()->safeEmail,
        ]);
    });

    return view('map');
});
Route::get('/map/json', function (){
    $markers = Illuminate\Support\Facades\DB::table('vds_storage.map')->get();
    return $markers;
});

Route::get('/contacts', 'ContactController@index')->middleware('auth')->name('Contacts');
Route::get('/contacts/all', 'ContactController@all')->middleware('auth');
Route::delete('/contacts/{id}', 'ContactController@destroy')->middleware('auth');
Route::post('/contacts/update', 'ContactController@update')->middleware('auth');
Route::post('/contacts/create', 'ContactController@create')->middleware('auth');
Route::post('/contacts/webhook', 'ContactController@webhook');

Route::get('/companies', 'CompanyController@index')->middleware('auth')->name('companies');
Route::get('/companies/all', 'CompanyController@all')->middleware('auth');
Route::delete('/companies/{id}', 'CompanyController@destroy')->middleware('auth');
Route::post('/companies/update', 'CompanyController@update')->middleware('auth');
Route::post('/companies/create', 'CompanyController@create')->middleware('auth');

Route::get('/subscriptions/create', 'SubscriptionController@create')->middleware('auth')->name('subscription.create');
Route::get('/subscriptions/{id}', 'SubscriptionController@show')->middleware('auth')->name('subscription');
Route::post('/subscriptions', 'SubscriptionController@store')->middleware('auth')->name('subscription.store');
Route::get('/subscriptions/{subscription}/edit', 'SubscriptionController@edit')->middleware('auth')->name('subscriptionEdit');
Route::post('/subscriptions/{subscription}/update', 'SubscriptionController@update')->middleware('auth')->name('subscriptionUpdate');
Route::get('/subscriptions/{id}/json', 'SubscriptionController@json')->middleware('auth')->name('subscriptionJson');
Route::get('/subscriptions/{id}/contacts', 'SubscriptionController@contacts')->middleware('auth')->name('subscriptionJson');
Route::post('/subscriptions/{id}/subscribe', 'SubscriptionController@subscribe')->middleware('auth');
Route::get('/subscriptions/{id}/unsubscribe/{contactId}', 'SubscriptionController@unsubscribe')->middleware('auth');
Route::delete('/subscriptions/{subscription}', 'SubscriptionController@destroy')->middleware('auth')->name('subscription.destroy');

Route::get('/companies/all', 'CompanyController@all')->middleware('auth')->name('company.all');
Route::get('/companies/{company}/json', 'CompanyController@json')->middleware('auth')->name('company.json');

//Route::get('/subscriberlist', 'SubscriberListController@index')->middleware('auth')->name('subscriberList');
Route::get('/subscriber/{id}/create', 'SubscriberController@create')->middleware('auth')->name('subscriberCreate');
Route::post('/subscriber/submit', 'SubscriberController@store')->middleware('auth')->name('subscriberSubmit');

Route::get('/log', 'LogController@index')->middleware('auth')->name('log');
Route::get('/log/json', 'LogController@all')->middleware('auth')->name('logJson');
Route::get('/log/digests', 'LogController@groupByDigests')->middleware('auth')->name('logDigest');
Route::get('/log/digests/json', 'LogController@digestsJson')->middleware('auth');
Route::get('/log/contacts', 'LogController@groupByContacts')->middleware('auth')->name('logContact');
Route::get('/log/contacts/json', 'LogController@contactsJson')->middleware('auth');
Route::get('/log/{log}/iframe', 'LogController@iframe')->middleware('auth')->name('logJson');
Route::get('/tracker','TrackerController@track');

Route::get('/clear', function () {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('clear-compiled');
    Artisan::call('config:cache');

    return '<h1>Cache facade value cleared </h1>';
});

Route::post('/upload', 'UploadController@uploadSubmit')->middleware('auth');
Route::post('/send', 'EmailController@send')->middleware('auth');
