<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function index()
    {
        return view('company.index');
    }

    public function all()
    {
        $company = Company::orderBy('name')->get();
        return $company;
        //return view('subscriberList', ['subscriberList' => $SubscriberList]);
    }

    public function json(Company $company)
    {
        //$company = Company::all();
        return $company;
        //return view('subscriberList', ['subscriberList' => $SubscriberList]);
    }

    public function destroy($id)
    {
        Company::destroy($id);
        return true;
    }

    public function update(Request $request)
    {
        $id = $request->key['id'];
        $values = $request->values;

        $company = Company::findOrFail($id);
        if (isset($values['name'])){
            $company->name = $values['name'];
        }

        $company->save();
        return true;
    }

    public function create(Request $request)
    {
        $values = $request->values;

        $company = new Company;
        $company->name = $values['name'];
        $company->save();

        return true;
    }

}
