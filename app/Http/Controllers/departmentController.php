<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\department;
use Illuminate\Http\Request;

class departmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-department'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }



        return view('/admin/.department.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-department'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.department.create');
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
     if(!Utility::permissionCheck('create-department'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();

        department::create($requestData);

        return redirect('admin/department')->with('flash_message', 'department added!');
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
    if(!Utility::permissionCheck('view-department'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $department = department::findOrFail($id);

        return view('/admin/.department.show', compact('department'));
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

     if(!Utility::permissionCheck('update-department'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $department = department::findOrFail($id);

        return view('/admin/.department.edit', compact('department'));
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

     if(!Utility::permissionCheck('update-department'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();

        $department = department::findOrFail($id);
        $department->update($requestData);

        return redirect('admin/department')->with('flash_message', 'department updated!');
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
     if(!Utility::permissionCheck('delete-department'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        department::destroy($id);

        return redirect('admin/department')->with('flash_message', 'department deleted!');
    }
}
