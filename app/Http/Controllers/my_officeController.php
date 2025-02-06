<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\client;
use App\Models\department;
use App\Models\division;
use App\Utility\Utility;
use App\Models\my_office;
use Illuminate\Http\Request;

class my_officeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-my_office'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }



        return view('/admin/.my_office.index' );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-my_office'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $data['divisions'] = division::get();
        $data['departments'] = department::get();
        $data['clients'] = client::get();
        return view('/admin/.my_office.create', $data);
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
     if(!Utility::permissionCheck('create-my_office'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'client_ref' => 'required'
		]);
        $requestData = $request->all();

        my_office::updateOrCreate($requestData,[]);

        return redirect('admin/my_office')->with('flash_message', 'my_office added!');
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
    if(!Utility::permissionCheck('view-my_office'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $my_office = my_office::findOrFail($id);

        return view('/admin/.my_office.show', compact('my_office'));
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

     if(!Utility::permissionCheck('update-my_office'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['my_office'] = my_office::findOrFail($id);
        $data['divisions'] = division::get();
        $data['departments'] = department::get();
        $data['clients'] = client::get();
        return view('/admin/.my_office.edit', $data);
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

     if(!Utility::permissionCheck('update-my_office'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'client_ref' => 'required'
		]);
        $requestData = $request->all();

        $my_office = my_office::findOrFail($id);
        $my_office->update($requestData);

        return redirect('admin/my_office')->with('flash_message', 'my_office updated!');
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
     if(!Utility::permissionCheck('delete-my_office'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        my_office::destroy($id);

        return redirect('admin/my_office')->with('flash_message', 'my_office deleted!');
    }
}
