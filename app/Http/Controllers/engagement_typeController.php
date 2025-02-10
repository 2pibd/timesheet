<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\engagement_type;
use Illuminate\Http\Request;

class engagement_typeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-engagement_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $engagement_type = engagement_type::where('title', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $engagement_type = engagement_type::latest()->paginate($perPage);
        }

        return view('/admin/.engagement_type.index', compact('engagement_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-engagement_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.engagement_type.create');
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
     if(!Utility::permissionCheck('create-engagement_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();
        
        engagement_type::create($requestData);

        return redirect('engagement_type')->with('flash_message', 'engagement_type added!');
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
    if(!Utility::permissionCheck('view-engagement_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $engagement_type = engagement_type::findOrFail($id);

        return view('/admin/.engagement_type.show', compact('engagement_type'));
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

     if(!Utility::permissionCheck('update-engagement_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $engagement_type = engagement_type::findOrFail($id);

        return view('/admin/.engagement_type.edit', compact('engagement_type'));
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

     if(!Utility::permissionCheck('update-engagement_type'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();
        
        $engagement_type = engagement_type::findOrFail($id);
        $engagement_type->update($requestData);

        return redirect('engagement_type')->with('flash_message', 'engagement_type updated!');
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
     if(!Utility::permissionCheck('delete-engagement_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        engagement_type::destroy($id);

        return redirect('engagement_type')->with('flash_message', 'engagement_type deleted!');
    }
}
