<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\invoice;
use Illuminate\Http\Request;

class invoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-invoice'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $invoice = invoice::where('invoice_number', 'LIKE', "%$keyword%")
                ->orWhere('invoice_contact', 'LIKE', "%$keyword%")
                ->orWhere('invoice_date', 'LIKE', "%$keyword%")
                ->orWhere('employer_ref', 'LIKE', "%$keyword%")
                ->orWhere('tax_year', 'LIKE', "%$keyword%")
                ->orWhere('posted_to', 'LIKE', "%$keyword%")
                ->orWhere('invoice_printed', 'LIKE', "%$keyword%")
                ->orWhere('invoice_net', 'LIKE', "%$keyword%")
                ->orWhere('invoice_vat', 'LIKE', "%$keyword%")
                ->orWhere('invoice_total', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $invoice = invoice::latest()->paginate($perPage);
        }

        return view('/admin/.invoice.index', compact('invoice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-invoice'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.invoice.create');
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
     if(!Utility::permissionCheck('create-invoice'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'invoice_number' => 'required'
		]);
        $requestData = $request->all();

        invoice::create($requestData);

        return redirect('invoice')->with('flash_message', 'invoice added!');
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
    if(!Utility::permissionCheck('view-invoice'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $invoice = invoice::findOrFail($id);

        return view('/admin/.invoice.show', compact('invoice'));
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

     if(!Utility::permissionCheck('update-invoice'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $invoice = invoice::findOrFail($id);

        return view('/admin/.invoice.edit', compact('invoice'));
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

     if(!Utility::permissionCheck('update-invoice'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'invoice_number' => 'required'
		]);
        $requestData = $request->all();

        $invoice = invoice::findOrFail($id);
        $invoice->update($requestData);

        return redirect('invoice')->with('flash_message', 'invoice updated!');
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
     if(!Utility::permissionCheck('delete-invoice'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        invoice::destroy($id);

        return redirect('invoice')->with('flash_message', 'invoice deleted!');
    }
}
