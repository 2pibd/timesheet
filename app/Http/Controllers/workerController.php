<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

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

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $worker = worker::where('user_login_id', 'LIKE', "%$keyword%")
                ->orWhere('emp_ref', 'LIKE', "%$keyword%")
                ->orWhere('personal_ref', 'LIKE', "%$keyword%")
                ->orWhere('first_forename', 'LIKE', "%$keyword%")
                ->orWhere('second_forename', 'LIKE', "%$keyword%")
                ->orWhere('third_forename', 'LIKE', "%$keyword%")
                ->orWhere('surname', 'LIKE', "%$keyword%")
                ->orWhere('paye_code', 'LIKE', "%$keyword%")
                ->orWhere('ni_number', 'LIKE', "%$keyword%")
                ->orWhere('gender', 'LIKE', "%$keyword%")
                ->orWhere('address_line1', 'LIKE', "%$keyword%")
                ->orWhere('address_line2', 'LIKE', "%$keyword%")
                ->orWhere('address_line3', 'LIKE', "%$keyword%")
                ->orWhere('address_line4', 'LIKE', "%$keyword%")
                ->orWhere('address_line5', 'LIKE', "%$keyword%")
                ->orWhere('post_code', 'LIKE', "%$keyword%")
                ->orWhere('country_id', 'LIKE', "%$keyword%")
                ->orWhere('tel_number', 'LIKE', "%$keyword%")
                ->orWhere('mobile_number', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('dob', 'LIKE', "%$keyword%")
                ->orWhere('worker_type', 'LIKE', "%$keyword%")
                ->orWhere('awr_type', 'LIKE', "%$keyword%")
                ->orWhere('non_cis_utr', 'LIKE', "%$keyword%")
                ->orWhere('known_as', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $worker = worker::latest()->paginate($perPage);
        }

        return view('/admin/.worker.index', compact('worker'));
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

        return view('/admin/.worker.create');
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
			'user_login_id' => 'required'
		]);
        $requestData = $request->all();
        
        worker::create($requestData);

        return redirect('worker')->with('flash_message', 'worker added!');
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

        $worker = worker::findOrFail($id);

        return view('/admin/.worker.edit', compact('worker'));
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
			'user_login_id' => 'required'
		]);
        $requestData = $request->all();
        
        $worker = worker::findOrFail($id);
        $worker->update($requestData);

        return redirect('worker')->with('flash_message', 'worker updated!');
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

        return redirect('worker')->with('flash_message', 'worker deleted!');
    }
}
