<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\flag_color;
use Illuminate\Http\Request;

class flag_colorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-flag_color'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $flag_color = flag_color::where('ref_code', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->orWhere('details', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $flag_color = flag_color::latest()->paginate($perPage);
        }

        return view('/admin/.flag_color.index', compact('flag_color'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-flag_color'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.flag_color.create');
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

     if(!Utility::permissionCheck('create-flag_color'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'color_code' => 'required'
		]);
        $requestData = $request->all();

        flag_color::create($requestData);

        return redirect('admin/flag_color')->with('flash_message', 'flag_color added!');
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
    if(!Utility::permissionCheck('view-flag_color'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $flag_color = flag_color::findOrFail($id);

        return view('/admin/.flag_color.show', compact('flag_color'));
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

     if(!Utility::permissionCheck('update-flag_color'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $flag_color = flag_color::findOrFail($id);

        return view('/admin/.flag_color.edit', compact('flag_color'));
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

     if(!Utility::permissionCheck('update-flag_color'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'ref_code' => 'required'
		]);
        $requestData = $request->all();

        $flag_color = flag_color::findOrFail($id);
        $flag_color->update($requestData);

        return redirect('admin/flag_color')->with('flash_message', 'flag_color updated!');
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
     if(!Utility::permissionCheck('delete-flag_color'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        flag_color::destroy($id);

        return redirect('admin/flag_color')->with('flash_message', 'flag_color deleted!');
    }
}
