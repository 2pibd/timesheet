<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\work_type;
use Illuminate\Http\Request;

class work_typeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-work_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $work_type = work_type::where('title', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $work_type = work_type::latest()->paginate($perPage);
        }

        return view('/admin/.work_type.index', compact('work_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-work_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.work_type.create');
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
     if(!Utility::permissionCheck('create-work_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();
        
        work_type::create($requestData);

        return redirect('work_type')->with('flash_message', 'work_type added!');
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
    if(!Utility::permissionCheck('view-work_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $work_type = work_type::findOrFail($id);

        return view('/admin/.work_type.show', compact('work_type'));
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

     if(!Utility::permissionCheck('update-work_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $work_type = work_type::findOrFail($id);

        return view('/admin/.work_type.edit', compact('work_type'));
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

     if(!Utility::permissionCheck('update-work_type'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();
        
        $work_type = work_type::findOrFail($id);
        $work_type->update($requestData);

        return redirect('work_type')->with('flash_message', 'work_type updated!');
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
     if(!Utility::permissionCheck('delete-work_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        work_type::destroy($id);

        return redirect('work_type')->with('flash_message', 'work_type deleted!');
    }
}
