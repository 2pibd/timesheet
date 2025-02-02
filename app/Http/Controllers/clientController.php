<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\client;
use App\Models\client_type;
use App\Models\Country;
use App\Models\cr;
use App\Models\Currency;
use App\Models\industry;
use App\Models\Language;
use App\Utility\Utility;
use Illuminate\Http\Request;

class clientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Utility::permissionCheck('view-client')) {
            return back()->with('error', Utility::getPermissionMsg());
        }


        return view('/admin/.client.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Utility::permissionCheck('create-client')) {
            return back()->with('error', Utility::getPermissionMsg());
        }


        $data['client_types'] = client_type::get();
        $data['currency'] = Currency::get();
        $data['country'] = Country::where('lang', 'en')->get();
        $data['industry'] = industry::orderBy('industry')->get();
        $data['allTabActive'] = false;
        $data['param'] = 0;
        $data['languages'] = Language::where('display_default', '1')->get();

        //$data['compliance_groups'] = compliance_group::get();
        $data['status'] = Helper::getEnumValues('clients','status');

        return view('/admin/.client.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cr $cr)
    {
        $data['client_types'] = client_type::get();
        return view('/admin/.client.create', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cr $cr)
    {
        //
    }
}
