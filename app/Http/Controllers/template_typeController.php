<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\template_type;
use Illuminate\Http\Request;

class template_typeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-template_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
            $perPage =   config('config.frontend_pagination');

        if (!empty($keyword)) {
            $template_type = template_type::where('type', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $template_type = template_type::latest()->paginate($perPage);
        }

        return view('/admin/.template_type.index', compact('template_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-template_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $data['status'] = Helper::getEnumValues('template_types', 'status');
        return view('/admin/.template_type.create', $data);
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
     if(!Utility::permissionCheck('create-template_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'type' => 'required'
		]);
        $requestData = $request->all();

        template_type::create($requestData);

        return redirect('template_type')->with('flash_message', 'template_type added!');
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
    if(!Utility::permissionCheck('view-template_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $template_type = template_type::findOrFail($id);

        return view('/admin/.template_type.show', compact('template_type'));
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

     if(!Utility::permissionCheck('update-template_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['template_type'] = template_type::findOrFail($id);
        $data['status'] = Helper::getEnumValues('template_types', 'status');
        return view('/admin/.template_type.edit',  $data);
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

     if(!Utility::permissionCheck('update-template_type'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'type' => 'required'
		]);
        $requestData = $request->all();

        $template_type = template_type::findOrFail($id);
        $template_type->update($requestData);

        return redirect('template_type')->with('flash_message', 'template_type updated!');
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
     if(!Utility::permissionCheck('delete-template_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        template_type::destroy($id);

        return redirect('template_type')->with('flash_message', 'template_type deleted!');
    }
}
