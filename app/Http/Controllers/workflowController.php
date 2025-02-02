<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\escalation_frequency;
use App\Utility\Utility;
use App\Models\workflow;
use Illuminate\Http\Request;

class workflowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-workflow'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $workflow = workflow::where('description', 'LIKE', "%$keyword%")
                ->orWhere('escalation_frequency_id', 'LIKE', "%$keyword%")
                ->orWhere('email_wet_signature', 'LIKE', "%$keyword%")
                ->orWhere('email_approval_signature', 'LIKE', "%$keyword%")
                ->orWhere('sso_link_expiry_days', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $workflow = workflow::latest()->paginate($perPage);
        }

        return view('/admin/.workflow.index', compact('workflow'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-workflow'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $data['escalation_frequencies'] =escalation_frequency:: get();
        $data['status'] = Helper::getEnumValues('workflows','status');
        return view('/admin/.workflow.create', $data);
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
     if(!Utility::permissionCheck('create-workflow'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'description' => 'required'
		]);
        $requestData = $request->all();
        $requestData['email_wet_signature'] = $request->email_wet_signature ? '1': '0';
        $requestData['email_approval_signature'] = $request->email_approval_signature ? '1': '0';
        workflow::create($requestData);

        return redirect('/admin/workflow')->with('flash_message', 'workflow added!');
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
    if(!Utility::permissionCheck('view-workflow'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $workflow = workflow::findOrFail($id);

        return view('/admin/.workflow.show', compact('workflow'));
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

     if(!Utility::permissionCheck('update-workflow'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['workflow'] = workflow::findOrFail($id);
        $data['escalation_frequencies'] =escalation_frequency:: get();
        $data['status'] = Helper::getEnumValues('workflows','status');
        return view('/admin/.workflow.edit', $data);
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

     if(!Utility::permissionCheck('update-workflow'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'description' => 'required'
		]);
        $requestData = $request->all();
        $requestData['email_wet_signature'] = $request->email_wet_signature ? '1': '0';
        $requestData['email_approval_signature'] = $request->email_approval_signature ? '1': '0';

        $workflow = workflow::findOrFail($id);
        $workflow->update($requestData);

        return redirect('/admin/workflow')->with('flash_message', 'workflow updated!');
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
     if(!Utility::permissionCheck('delete-workflow'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        workflow::destroy($id);

        return redirect('/admin/workflow')->with('flash_message', 'workflow deleted!');
    }
}
