<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\division;
use Illuminate\Http\Request;

class divisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-division'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $division = division::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $division = division::latest()->paginate($perPage);
        }

        return view('/admin/.division.index', compact('division'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-division'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.division.create');
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
     if(!Utility::permissionCheck('create-division'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();

        division::create($requestData);

        return redirect('admin/division')->with('flash_message', 'division added!');
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
    if(!Utility::permissionCheck('view-division'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $division = division::findOrFail($id);

        return view('/admin/.division.show', compact('division'));
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

     if(!Utility::permissionCheck('update-division'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $division = division::findOrFail($id);

        return view('/admin/.division.edit', compact('division'));
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

     if(!Utility::permissionCheck('update-division'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();

        $division = division::findOrFail($id);
        $division->update($requestData);

        return redirect('admin/division')->with('flash_message', 'division updated!');
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
     if(!Utility::permissionCheck('delete-division'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        division::destroy($id);

        return redirect('admin/division')->with('flash_message', 'division deleted!');
    }
}
