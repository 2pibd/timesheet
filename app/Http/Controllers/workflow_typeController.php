<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Utility\Utility;
use App\Models\workflow_type;
use Illuminate\Http\Request;

class workflow_typeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-workflow_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $workflow_type = workflow_type::where('title', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $workflow_type = workflow_type::latest()->paginate($perPage);
        }

        return view('/admin/.workflow_type.index', compact('workflow_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-workflow_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.workflow_type.create');
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
     if(!Utility::permissionCheck('create-workflow_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();
        
        workflow_type::create($requestData);

        return redirect('workflow_type')->with('flash_message', 'workflow_type added!');
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
    if(!Utility::permissionCheck('view-workflow_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $workflow_type = workflow_type::findOrFail($id);

        return view('/admin/.workflow_type.show', compact('workflow_type'));
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

     if(!Utility::permissionCheck('update-workflow_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $workflow_type = workflow_type::findOrFail($id);

        return view('/admin/.workflow_type.edit', compact('workflow_type'));
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

     if(!Utility::permissionCheck('update-workflow_type'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();
        
        $workflow_type = workflow_type::findOrFail($id);
        $workflow_type->update($requestData);

        return redirect('workflow_type')->with('flash_message', 'workflow_type updated!');
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
     if(!Utility::permissionCheck('delete-workflow_type'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        workflow_type::destroy($id);

        return redirect('workflow_type')->with('flash_message', 'workflow_type deleted!');
    }
}
