<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\consultant;
use Illuminate\Http\Request;

class consultantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-consultant'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $consultant = consultant::where('user_id', 'LIKE', "%$keyword%")
                ->orWhere('user_ref', 'LIKE', "%$keyword%")
                ->orWhere('ref_code', 'LIKE', "%$keyword%")
                ->orWhere('access_code', 'LIKE', "%$keyword%")
                ->orWhere('officeial_id', 'LIKE', "%$keyword%")
                ->orWhere('work_telephone', 'LIKE', "%$keyword%")
                ->orWhere('mobile_number', 'LIKE', "%$keyword%")
                ->orWhere('address_line1', 'LIKE', "%$keyword%")
                ->orWhere('address_line2', 'LIKE', "%$keyword%")
                ->orWhere('address_line3', 'LIKE', "%$keyword%")
                ->orWhere('address_line4', 'LIKE', "%$keyword%")
                ->orWhere('post_code', 'LIKE', "%$keyword%")
                ->orWhere('office_manager', 'LIKE', "%$keyword%")
                ->orWhere('security_admin', 'LIKE', "%$keyword%")
                ->orWhere('read_only_access', 'LIKE', "%$keyword%")
                ->orWhere('template_id', 'LIKE', "%$keyword%")
                ->orWhere('language_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $consultant = consultant::latest()->paginate($perPage);
        }

        return view('/admin/.consultant.index', compact('consultant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-consultant'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.consultant.create');
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
     if(!Utility::permissionCheck('create-consultant'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'user_id' => 'required'
		]);
        $requestData = $request->all();
        
        consultant::create($requestData);

        return redirect('consultant')->with('flash_message', 'consultant added!');
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
    if(!Utility::permissionCheck('view-consultant'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $consultant = consultant::findOrFail($id);

        return view('/admin/.consultant.show', compact('consultant'));
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

     if(!Utility::permissionCheck('update-consultant'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $consultant = consultant::findOrFail($id);

        return view('/admin/.consultant.edit', compact('consultant'));
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

     if(!Utility::permissionCheck('update-consultant'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'user_id' => 'required'
		]);
        $requestData = $request->all();
        
        $consultant = consultant::findOrFail($id);
        $consultant->update($requestData);

        return redirect('consultant')->with('flash_message', 'consultant updated!');
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
     if(!Utility::permissionCheck('delete-consultant'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        consultant::destroy($id);

        return redirect('consultant')->with('flash_message', 'consultant deleted!');
    }
}
