<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\supplier;
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

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $supplier = supplier::where('employer_id', 'LIKE', "%$keyword%")
                ->orWhere('supplier_ref', 'LIKE', "%$keyword%")
                ->orWhere('business_name', 'LIKE', "%$keyword%")
                ->orWhere('department', 'LIKE', "%$keyword%")
                ->orWhere('division', 'LIKE', "%$keyword%")
                ->orWhere('legal_status', 'LIKE', "%$keyword%")
                ->orWhere('supplier_type', 'LIKE', "%$keyword%")
                ->orWhere('remittance_to', 'LIKE', "%$keyword%")
                ->orWhere('payment_option', 'LIKE', "%$keyword%")
                ->orWhere('incorpotrate_date', 'LIKE', "%$keyword%")
                ->orWhere('company_reg_no', 'LIKE', "%$keyword%")
                ->orWhere('schedule_date', 'LIKE', "%$keyword%")
                ->orWhere('number', 'LIKE', "%$keyword%")
                ->orWhere('vat_number', 'LIKE', "%$keyword%")
                ->orWhere('vat_area', 'LIKE', "%$keyword%")
                ->orWhere('vat_rate', 'LIKE', "%$keyword%")
                ->orWhere('payment_terms', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $supplier = supplier::latest()->paginate($perPage);
        }

        return view('/admin/.supplier.index', compact('supplier'));
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

        return view('/admin/.supplier.create');
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
        
        supplier::create($requestData);

        return redirect('supplier')->with('flash_message', 'supplier added!');
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

        $supplier = supplier::findOrFail($id);

        return view('/admin/.supplier.edit', compact('supplier'));
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
        
        $supplier = supplier::findOrFail($id);
        $supplier->update($requestData);

        return redirect('supplier')->with('flash_message', 'supplier updated!');
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

        return redirect('supplier')->with('flash_message', 'supplier deleted!');
    }
}
