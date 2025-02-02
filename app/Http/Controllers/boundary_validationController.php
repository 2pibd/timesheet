<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\division;
use App\Utility\Utility;
use App\Models\boundary_validation;
use Illuminate\Http\Request;

class boundary_validationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-boundary_validation'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $boundary_validation = boundary_validation::where('division_id', 'LIKE', "%$keyword%")
                ->orWhere('hour_day', 'LIKE', "%$keyword%")
                ->orWhere('days_day', 'LIKE', "%$keyword%")
                ->orWhere('hour_week', 'LIKE', "%$keyword%")
                ->orWhere('days_week', 'LIKE', "%$keyword%")
                ->orWhere('hour_month', 'LIKE', "%$keyword%")
                ->orWhere('days_month', 'LIKE', "%$keyword%")
                ->orWhere('hour_year', 'LIKE', "%$keyword%")
                ->orWhere('days_year', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $boundary_validation = boundary_validation::latest()->paginate($perPage);
        }

        return view('/admin/.boundary_validation.index', compact('boundary_validation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-boundary_validation'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['divisions'] = division::orderBy('name','ASC')->get();
        $data['status'] = Helper::getEnumValues('boundary_validations','status');

        return view('/admin/.boundary_validation.create', $data);
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
     if(!Utility::permissionCheck('create-boundary_validation'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'division_id' => 'required'
		]);
        $requestData = $request->all();

        boundary_validation::create($requestData);

        return redirect('admin/boundary_validation')->with('flash_message', 'boundary_validation added!');
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
    if(!Utility::permissionCheck('view-boundary_validation'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $boundary_validation = boundary_validation::findOrFail($id);

        return view('/admin/.boundary_validation.show', compact('boundary_validation'));
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

     if(!Utility::permissionCheck('update-boundary_validation'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['boundary_validation'] = boundary_validation::findOrFail($id);
        $data['divisions'] = division::orderBy('name','ASC')->get();
        $data['status'] = Helper::getEnumValues('boundary_validations','status');
        return view('/admin/.boundary_validation.edit',  $data);
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

     if(!Utility::permissionCheck('update-boundary_validation'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'division_id' => 'required'
		]);
        $requestData = $request->all();

        $boundary_validation = boundary_validation::findOrFail($id);
        $boundary_validation->update($requestData);

        return redirect('admin/boundary_validation')->with('flash_message', 'boundary_validation updated!');
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
     if(!Utility::permissionCheck('delete-boundary_validation'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        boundary_validation::destroy($id);

        return redirect('admin/boundary_validation')->with('flash_message', 'boundary_validation deleted!');
    }
}
