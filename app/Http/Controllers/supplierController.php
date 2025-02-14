<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\client;
use App\Models\department;
use App\Models\division;
use App\Models\placement_type;
use App\Utility\Utility;
use App\Models\supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class supplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-supplier'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }


        return view('/admin/.supplier.index' );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-supplier'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $data['employers'] = client::get();
        $data['placement_types'] = placement_type::where('section','Supplier')->get();
        $data['divisions'] = division::get();
        $data['departments'] = department::get();
        return view('/admin/.supplier.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
     if(!Utility::permissionCheck('create-supplier'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'employer_id' => 'required'
		]);
        $requestData = $request->all();
        if (isset($request->incorporate_date)) $requestData['incorporate_date'] = Carbon::createFromFormat('d/m/Y', $request->incorporate_date)->format('Y-m-d');
        if (isset($request->schedule_date)) $requestData['schedule_date'] = Carbon::createFromFormat('d/m/Y', $request->schedule_date)->format('Y-m-d');

        supplier::create($requestData);

        return redirect('admin/supplier')->with('flash_message', 'supplier added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
    if(!Utility::permissionCheck('view-supplier'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $supplier = supplier::findOrFail($id);

        return view('/admin/.supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {

     if(!Utility::permissionCheck('update-supplier'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['supplier'] = supplier::findOrFail($id);
        $data['employers'] = client::get();
        $data['placement_types'] = placement_type::where('section','Supplier')->get();
        $data['divisions'] = division::get();
        $data['departments'] = department::get();
        return view('/admin/.supplier.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

     if(!Utility::permissionCheck('update-supplier'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'employer_id' => 'required'
		]);
        $requestData = $request->all();
        if (isset($request->incorporate_date)) $requestData['incorporate_date'] = Carbon::createFromFormat('d/m/Y', $request->incorporate_date)->format('Y-m-d');
        if (isset($request->schedule_date)) $requestData['schedule_date'] = Carbon::createFromFormat('d/m/Y', $request->schedule_date)->format('Y-m-d');

        $supplier = supplier::findOrFail($id);
        $supplier->update($requestData);

        return redirect('admin/supplier')->with('flash_message', 'supplier updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
     if(!Utility::permissionCheck('delete-supplier'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        supplier::destroy($id);

        return redirect('admin/supplier')->with('flash_message', 'supplier deleted!');
    }
}
