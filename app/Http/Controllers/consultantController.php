<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Language;
use App\Models\name_title;
use App\Models\User;
use App\Utility\Utility;
use App\Models\consultant;
use Illuminate\Http\Request;
use SebastianBergmann\Template\Template;

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
                ->orWhere('official_id', 'LIKE', "%$keyword%")
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
        $data['name_titles'] = name_title::all();
        $data['languages'] = Language::where('display_default', '1')->get();
        return view('/admin/.consultant.create', $data);
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
			'first_name' => 'required'
		]);
        $userData = $request->all();
        $userData['name'] = $request->name_title . '  ' . $request->first_name . '  ' . $request->middle_name . '  ' . $request->last_name;

        $userData['status'] =  $request->status ? 'Active': 'Inactive';

        $userData['remember_token'] = md5(time());
        $userData['password'] = (!empty($request->password)) ? bcrypt($request->password) : '';

        $user = User::create($userData);
        $user->syncRoles('Consultant');

        $requestData = $request->all();
        $requestData['user_id'] = $user->id;
        consultant::create($requestData);

        return redirect('admin/consultant')->with('flash_message', 'consultant added!');
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

        $data['consultant'] = consultant::findOrFail($id);
        $data['name_titles'] = name_title::all();
        $data['languages'] = Language::where('display_default', '1')->get();

        return view('/admin/.consultant.edit',  $data);
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
			'first_name' => 'required'
		]);
        $requestData = $request->all();

        $consultant = consultant::findOrFail($id);
        $consultant->update($requestData);

        if($consultant  ) {
             $userData['name'] = $request->name_title . '  ' . $request->first_name . '  ' . $request->middle_name . '  ' . $request->last_name;
             $userData['status'] =  $request->status ? 'Active': 'Inactive';
             $userData['remember_token'] = md5(time());
                $userData['password'] = (!empty($request->password)) ? bcrypt($request->password) : (isset($consultant->profile)? $consultant->profile->password : '');

            $user = User::updateOrCreate(
            [
                'id'=>$consultant->user_id
            ],
                $userData
            );
          //  $consultant->profile->update($userData);
        }

        return redirect('admin/consultant')->with('flash_message', 'consultant updated!');
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

        return redirect('admin/consultant')->with('flash_message', 'consultant deleted!');
    }
}
