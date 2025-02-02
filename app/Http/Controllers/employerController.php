<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\employer;
use Illuminate\Http\Request;

class employerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-employer'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $employer = employer::where('emp_ref', 'LIKE', "%$keyword%")
                ->orWhere('location_id', 'LIKE', "%$keyword%")
                ->orWhere('division_id', 'LIKE', "%$keyword%")
                ->orWhere('department_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $employer = employer::latest()->paginate($perPage);
        }

        return view('/admin/.employer.index', compact('employer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-employer'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.employer.create');
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
     if(!Utility::permissionCheck('create-employer'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'emp_ref' => 'required'
		]);
        $requestData = $request->all();
        
        employer::create($requestData);

        return redirect('employer')->with('flash_message', 'employer added!');
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
    if(!Utility::permissionCheck('view-employer'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $employer = employer::findOrFail($id);

        return view('/admin/.employer.show', compact('employer'));
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

     if(!Utility::permissionCheck('update-employer'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $employer = employer::findOrFail($id);

        return view('/admin/.employer.edit', compact('employer'));
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

     if(!Utility::permissionCheck('update-employer'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'emp_ref' => 'required'
		]);
        $requestData = $request->all();
        
        $employer = employer::findOrFail($id);
        $employer->update($requestData);

        return redirect('employer')->with('flash_message', 'employer updated!');
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
     if(!Utility::permissionCheck('delete-employer'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        employer::destroy($id);

        return redirect('employer')->with('flash_message', 'employer deleted!');
    }
}
