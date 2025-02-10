<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\awr_type;
use App\Models\client;
use App\Models\consultant;
use App\Models\Country;
use App\Models\department;
use App\Models\division;
use App\Models\engagement_type;
use App\Models\name_title;
use App\Models\placement_type;
use App\Models\supplier;
use App\Models\User;
use App\Models\work_type;
use App\Utility\Utility;
use App\Models\worker;
use Illuminate\Http\Request;

class workerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-worker'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }


        return view('/admin/.worker.index' );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-worker'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $data['employers'] = client::get();
        $data['engagement_types'] = engagement_type::get();
        $data['worker_types'] = work_type:: get();
        $data['awr_types'] = awr_type:: get();
        $data['countries'] = Country::where('is_default','1')->get();
        $data['divisions'] = division::get();
        $data['departments'] = department::get();
        $data['suppliers'] = supplier::get();
        $data['consultants'] = consultant::get();
        $data['name_titles'] = name_title::all();
        return view('/admin/.worker.create', $data);
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
     if(!Utility::permissionCheck('create-worker'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'employer_id' => 'required',
			'email' => 'required',
		]);

        $userData = $request->all();
        $userData['name'] =  $request->name_title . '  ' .  $request->first_name . '  ' . $request->middle_name . '  ' . $request->last_name;

        $userData['status'] =  $request->status ? 'Active': 'Inactive';

        $userData['remember_token'] = md5(time());
        $userData['password'] = (!empty($request->password)) ? bcrypt($request->password) : '';

        $user = User::create($userData);
        $user->syncRoles('Consultant');


        $requestData = $request->all();

        $requestData['user_id'] = $user->id;
        worker::create($requestData);


        return redirect('admin/worker')->with('flash_message', 'worker added!');
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
    if(!Utility::permissionCheck('view-worker'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $worker = worker::findOrFail($id);

        return view('/admin/.worker.show', compact('worker'));
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

     if(!Utility::permissionCheck('update-worker'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['worker'] = worker::findOrFail($id);
        $data['employers'] = client::get();
        $data['engagement_types'] = engagement_type::get();
        $data['worker_types'] = work_type:: get();
        $data['awr_types'] = awr_type:: get();
        $data['countries'] = Country::where('is_default','1')->get();
        $data['divisions'] = division::get();
        $data['departments'] = department::get();
        $data['suppliers'] = supplier::get();
        $data['consultants'] = consultant::get();
        $data['name_titles'] = name_title::all();
        return view('/admin/.worker.edit', $data);
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

     if(!Utility::permissionCheck('update-worker'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'employer_id' => 'required',
            'email' => 'required',
		]);
        $requestData = $request->all();

        $worker = worker::findOrFail($id);

        if($worker) {
            $userData = $request->all();
            $userData['name'] =   $request->name_title . '  ' .  $request->first_name . '  ' . $request->middle_name . '  ' . $request->last_name;
            $userData['status'] =  $request->status ? 'Active': 'Inactive';
            $userData['remember_token'] = md5(time());
            $userData['password'] = (!empty($request->password)) ? bcrypt($request->password) : (isset($worker->profile)? $worker->profile->password : '');

            $user = User::updateOrCreate(
                [
                    'id'=>$worker->user_id
                ],
                $userData
            );
            $requestData['user_id'] = $user->id;
            //  $consultant->profile->update($userData);
        }
        $worker->update($requestData);
        return redirect('admin/worker')->with('flash_message', 'worker updated!');
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
     if(!Utility::permissionCheck('delete-worker'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        worker::destroy($id);

        return redirect('admin/worker')->with('flash_message', 'worker deleted!');
    }
}
