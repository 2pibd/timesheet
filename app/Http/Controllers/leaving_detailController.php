<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\leaving_detail;
use Illuminate\Http\Request;

class leaving_detailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-leaving_details'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $leaving_details = leaving_detail::where('employer_id', 'LIKE', "%$keyword%")
                ->orWhere('personal_ref', 'LIKE', "%$keyword%")
                ->orWhere('leaving_date', 'LIKE', "%$keyword%")
                ->orWhere('leaving_reason', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $leaving_details = leaving_detail::latest()->paginate($perPage);
        }

        return view('/admin/.leaving_details.index', compact('leaving_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-leaving_details'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.leaving_details.create');
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
     if(!Utility::permissionCheck('create-leaving_details'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'employer_id' => 'required'
		]);
        $requestData = $request->all();
        
        leaving_detail::create($requestData);

        return redirect('leaving_details')->with('flash_message', 'leaving_detail added!');
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
    if(!Utility::permissionCheck('view-leaving_details'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $leaving_detail = leaving_detail::findOrFail($id);

        return view('/admin/.leaving_details.show', compact('leaving_detail'));
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

     if(!Utility::permissionCheck('update-leaving_details'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $leaving_detail = leaving_detail::findOrFail($id);

        return view('/admin/.leaving_details.edit', compact('leaving_detail'));
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

     if(!Utility::permissionCheck('update-leaving_details'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'employer_id' => 'required'
		]);
        $requestData = $request->all();
        
        $leaving_detail = leaving_detail::findOrFail($id);
        $leaving_detail->update($requestData);

        return redirect('leaving_details')->with('flash_message', 'leaving_detail updated!');
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
     if(!Utility::permissionCheck('delete-leaving_details'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        leaving_detail::destroy($id);

        return redirect('leaving_details')->with('flash_message', 'leaving_detail deleted!');
    }
}
