<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\business_account;
use Illuminate\Http\Request;

class business_accountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-business_account'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }


        return view('/admin/.business_account.index' );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-business_account'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.business_account.create');
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
     if(!Utility::permissionCheck('create-business_account'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'business_name' => 'required'
		]);
        $requestData = $request->all();

        business_account::create($requestData);

        return redirect('business_account')->with('flash_message', 'business_account added!');
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
    if(!Utility::permissionCheck('view-business_account'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $business_account = business_account::findOrFail($id);

        return view('/admin/.business_account.show', compact('business_account'));
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

     if(!Utility::permissionCheck('update-business_account'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $business_account = business_account::findOrFail($id);

        return view('/admin/.business_account.edit', compact('business_account'));
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

     if(!Utility::permissionCheck('update-business_account'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'business_name' => 'required'
		]);
        $requestData = $request->all();

        $business_account = business_account::findOrFail($id);
        $business_account->update($requestData);

        return redirect('business_account')->with('flash_message', 'business_account updated!');
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
     if(!Utility::permissionCheck('delete-business_account'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        business_account::destroy($id);

        return redirect('business_account')->with('flash_message', 'business_account deleted!');
    }
}
