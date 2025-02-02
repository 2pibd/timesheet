<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\timesheet;
use Illuminate\Http\Request;

class timesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-timesheet'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $timesheet = timesheet::where('worker_id', 'LIKE', "%$keyword%")
                ->orWhere('assignment_id', 'LIKE', "%$keyword%")
                ->orWhere('timesheet_date', 'LIKE', "%$keyword%")
                ->orWhere('timesheet_number', 'LIKE', "%$keyword%")
                ->orWhere('tax_year', 'LIKE', "%$keyword%")
                ->orWhere('timesheet_authoriser_id', 'LIKE', "%$keyword%")
                ->orWhere('start_week', 'LIKE', "%$keyword%")
                ->orWhere('additional_expense', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $timesheet = timesheet::latest()->paginate($perPage);
        }

        return view('/admin/.timesheet.index', compact('timesheet'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-timesheet'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.timesheet.create');
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
     if(!Utility::permissionCheck('create-timesheet'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'worker_id' => 'required'
		]);
        $requestData = $request->all();
        
        timesheet::create($requestData);

        return redirect('timesheet')->with('flash_message', 'timesheet added!');
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
    if(!Utility::permissionCheck('view-timesheet'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $timesheet = timesheet::findOrFail($id);

        return view('/admin/.timesheet.show', compact('timesheet'));
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

     if(!Utility::permissionCheck('update-timesheet'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $timesheet = timesheet::findOrFail($id);

        return view('/admin/.timesheet.edit', compact('timesheet'));
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

     if(!Utility::permissionCheck('update-timesheet'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'worker_id' => 'required'
		]);
        $requestData = $request->all();
        
        $timesheet = timesheet::findOrFail($id);
        $timesheet->update($requestData);

        return redirect('timesheet')->with('flash_message', 'timesheet updated!');
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
     if(!Utility::permissionCheck('delete-timesheet'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        timesheet::destroy($id);

        return redirect('timesheet')->with('flash_message', 'timesheet deleted!');
    }
}
