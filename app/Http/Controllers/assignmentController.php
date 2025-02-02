<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\assignment;
use Illuminate\Http\Request;

class assignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-assignment'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $assignment = assignment::where('consultent_id', 'LIKE', "%$keyword%")
                ->orWhere('worker_surname', 'LIKE', "%$keyword%")
                ->orWhere('worker_forename', 'LIKE', "%$keyword%")
                ->orWhere('parsonal_ref', 'LIKE', "%$keyword%")
                ->orWhere('assignment_type_id', 'LIKE', "%$keyword%")
                ->orWhere('start_date', 'LIKE', "%$keyword%")
                ->orWhere('expected_end_date', 'LIKE', "%$keyword%")
                ->orWhere('actual_end_date', 'LIKE', "%$keyword%")
                ->orWhere('job_category', 'LIKE', "%$keyword%")
                ->orWhere('online_expences', 'LIKE', "%$keyword%")
                ->orWhere('online_expences_worker_print', 'LIKE', "%$keyword%")
                ->orWhere('online_escalation_type_override', 'LIKE', "%$keyword%")
                ->orWhere('online_timesheet_type_id', 'LIKE', "%$keyword%")
                ->orWhere('auth_group', 'LIKE', "%$keyword%")
                ->orWhere('prev_service', 'LIKE', "%$keyword%")
                ->orWhere('timesheet_frequency', 'LIKE', "%$keyword%")
                ->orWhere('assignment_en_reason', 'LIKE', "%$keyword%")
                ->orWhere('workflow_type', 'LIKE', "%$keyword%")
                ->orWhere('direct_client', 'LIKE', "%$keyword%")
                ->orWhere('booked_by', 'LIKE', "%$keyword%")
                ->orWhere('client_id', 'LIKE', "%$keyword%")
                ->orWhere('ts_authoriser', 'LIKE', "%$keyword%")
                ->orWhere('auth_group_details', 'LIKE', "%$keyword%")
                ->orWhere('contact_name', 'LIKE', "%$keyword%")
                ->orWhere('reporting_to', 'LIKE', "%$keyword%")
                ->orWhere('purchase_order', 'LIKE', "%$keyword%")
                ->orWhere('delivery_address', 'LIKE', "%$keyword%")
                ->orWhere('invoice_address', 'LIKE', "%$keyword%")
                ->orWhere('report_to_client', 'LIKE', "%$keyword%")
                ->orWhere('invoice_to_client', 'LIKE', "%$keyword%")
                ->orWhere('holiday_entitlement_hourly', 'LIKE', "%$keyword%")
                ->orWhere('holiday_entitlement_week_per_annum', 'LIKE', "%$keyword%")
                ->orWhere('worker_awr_status', 'LIKE', "%$keyword%")
                ->orWhere('awr_qualification_weeks', 'LIKE', "%$keyword%")
                ->orWhere('actual_qualificatin_date', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $assignment = assignment::latest()->paginate($perPage);
        }

        return view('/admin/.assignment.index', compact('assignment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-assignment'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.assignment.create');
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
     if(!Utility::permissionCheck('create-assignment'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'consultent_id' => 'required'
		]);
        $requestData = $request->all();
        
        assignment::create($requestData);

        return redirect('assignment')->with('flash_message', 'assignment added!');
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
    if(!Utility::permissionCheck('view-assignment'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $assignment = assignment::findOrFail($id);

        return view('/admin/.assignment.show', compact('assignment'));
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

     if(!Utility::permissionCheck('update-assignment'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $assignment = assignment::findOrFail($id);

        return view('/admin/.assignment.edit', compact('assignment'));
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

     if(!Utility::permissionCheck('update-assignment'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'consultent_id' => 'required'
		]);
        $requestData = $request->all();
        
        $assignment = assignment::findOrFail($id);
        $assignment->update($requestData);

        return redirect('assignment')->with('flash_message', 'assignment updated!');
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
     if(!Utility::permissionCheck('delete-assignment'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        assignment::destroy($id);

        return redirect('assignment')->with('flash_message', 'assignment deleted!');
    }
}
