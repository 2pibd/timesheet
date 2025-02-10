<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\awr_type;
use Illuminate\Http\Request;

class awr_typeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-awr_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $awr_type = awr_type::where('title', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $awr_type = awr_type::latest()->paginate($perPage);
        }

        return view('/admin/.awr_type.index', compact('awr_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-awr_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.awr_type.create');
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
     if(!Utility::permissionCheck('create-awr_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();
        
        awr_type::create($requestData);

        return redirect('awr_type')->with('flash_message', 'awr_type added!');
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
    if(!Utility::permissionCheck('view-awr_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $awr_type = awr_type::findOrFail($id);

        return view('/admin/.awr_type.show', compact('awr_type'));
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

     if(!Utility::permissionCheck('update-awr_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $awr_type = awr_type::findOrFail($id);

        return view('/admin/.awr_type.edit', compact('awr_type'));
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

     if(!Utility::permissionCheck('update-awr_type'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();
        
        $awr_type = awr_type::findOrFail($id);
        $awr_type->update($requestData);

        return redirect('awr_type')->with('flash_message', 'awr_type updated!');
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
     if(!Utility::permissionCheck('delete-awr_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        awr_type::destroy($id);

        return redirect('awr_type')->with('flash_message', 'awr_type deleted!');
    }
}
