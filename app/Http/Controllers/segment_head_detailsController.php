<?php

namespace App\Http\Controllers;


use App\Helpers\Helper;
use App\Models\country;
use App\Models\currency;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\segment_head;
use App\Utility\Utility;
use App\Models\segment_head_detail;
use Illuminate\Http\Request;

class segment_head_detailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-segment_head_details'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $query = segment_head_detail::where('seg_head_id', 'LIKE', "%$keyword%")
                ->orWhere('seg_code', 'LIKE', "%$keyword%")
                ->orWhere('details', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest();
        } else {
            $query= segment_head_detail::latest();
        }
         $segment_head_details = $query->with('segment_head')->paginate($perPage);
        return view('/admin/.segment_head_details.index', compact('segment_head_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-segment_head_details'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $data['enumstatus'] = Helper::getEnumValues('segment_head_details', 'status');
        $data['segment_head'] = segment_head::where('status','Active')->get();

        $data['currency'] = currency::get();
        $data['country'] = country::where('lang', 'en')->get();
        return view('/admin/.segment_head_details.create', $data);
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
     if(!Utility::permissionCheck('create-segment_head_details'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'seg_head_id' => 'required',
            'seg_code' => 'required|unique:segment_head_details,seg_code' ,
		]);
        $requestData = $request->all();

        segment_head_detail::create($requestData);

        return redirect('segment_head_details')->with('flash_message', 'segment_head_detail added!');
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
    if(!Utility::permissionCheck('view-segment_head_details'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $segment_head_detail = segment_head_detail::findOrFail($id);

        return view('/admin/.segment_head_details.show', compact('segment_head_detail'));
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

     if(!Utility::permissionCheck('update-segment_head_details'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['segment_head_detail'] = segment_head_detail::findOrFail($id);
        $data['segment_head'] = segment_head::where('status','Active')->get();
        $data['enumstatus'] = Helper::getEnumValues('segment_head_details', 'status');
        $data['currency'] = currency::get();
        $data['country'] = country::where('lang', 'en')->get();
        return view('/admin/.segment_head_details.edit', $data);
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

     if(!Utility::permissionCheck('update-segment_head_details'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'seg_head_id' => 'required',
            //'seg_code' => 'required|seg_code|unique:segment_head_details,seg_code,' . $id,
		]);
        $requestData = $request->all();

        $segment_head_detail = segment_head_detail::findOrFail($id);
        $segment_head_detail->update($requestData);

        return redirect('segment_head_details')->with('flash_message', 'segment_head_detail updated!');
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
     if(!Utility::permissionCheck('delete-segment_head_details'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        segment_head_detail::destroy($id);

        return redirect('segment_head_details')->with('flash_message', 'segment_head_detail deleted!');
    }
}
