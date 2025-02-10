<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\placement_type;
use Illuminate\Http\Request;

class placement_typeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-placement_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $placement_type = placement_type::where('title', 'LIKE', "%$keyword%")
                ->orWhere('section', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $placement_type = placement_type::latest()->paginate($perPage);
        }

        return view('/admin/.placement_type.index', compact('placement_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-placement_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.placement_type.create');
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
     if(!Utility::permissionCheck('create-placement_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();
        
        placement_type::create($requestData);

        return redirect('placement_type')->with('flash_message', 'placement_type added!');
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
    if(!Utility::permissionCheck('view-placement_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $placement_type = placement_type::findOrFail($id);

        return view('/admin/.placement_type.show', compact('placement_type'));
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

     if(!Utility::permissionCheck('update-placement_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $placement_type = placement_type::findOrFail($id);

        return view('/admin/.placement_type.edit', compact('placement_type'));
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

     if(!Utility::permissionCheck('update-placement_type'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();
        
        $placement_type = placement_type::findOrFail($id);
        $placement_type->update($requestData);

        return redirect('placement_type')->with('flash_message', 'placement_type updated!');
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
     if(!Utility::permissionCheck('delete-placement_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        placement_type::destroy($id);

        return redirect('placement_type')->with('flash_message', 'placement_type deleted!');
    }
}
