<?php

namespace App\Http\Controllers;


use App\Helpers\Helper;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Utility\Utility;
use App\Models\segment_head;
use Illuminate\Http\Request;

class segment_headController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-segment_head'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $segment_head = segment_head::where('seg_name', 'LIKE', "%$keyword%")
                ->orWhere('seg_code', 'LIKE', "%$keyword%")
                ->orWhere('details', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $segment_head = segment_head::latest()->paginate($perPage);
        }

        return view('/admin/.segment_head.index', compact('segment_head'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-segment_head'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $data['enumstatus'] = Helper::getEnumValues('segment_heads', 'status');
        return view('/admin/.segment_head.create', $data);
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
     if(!Utility::permissionCheck('create-segment_head'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'seg_name' => 'required'
		]);
        $requestData = $request->all();

        segment_head::create($requestData);

        return redirect('admin/segment_head')->with('flash_message', 'segment_head added!');
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
    if(!Utility::permissionCheck('view-segment_head'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $segment_head = segment_head::findOrFail($id);

        return view('/admin/.segment_head.show', compact('segment_head'));
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

     if(!Utility::permissionCheck('update-segment_head'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['segment_head'] = segment_head::findOrFail($id);
        $data['enumstatus'] = Helper::getEnumValues('segment_heads', 'status');
        return view('/admin/.segment_head.edit', $data);
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

     if(!Utility::permissionCheck('update-segment_head'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'seg_name' => 'required'
		]);
        $requestData = $request->all();

        $segment_head = segment_head::findOrFail($id);
        $segment_head->update($requestData);

        return redirect('admin/segment_head')->with('flash_message', 'segment_head updated!');
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
     if(!Utility::permissionCheck('delete-segment_head'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        segment_head::destroy($id);

        return redirect('admin/segment_head')->with('flash_message', 'segment_head deleted!');
    }
}
