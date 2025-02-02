<?php

namespace App\Http\Controllers;


use App\Helpers\Helper;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\segment_head;
use App\Models\segment_head_detail;
use App\Utility\Utility;
use App\Models\segment_structure_info;
use Illuminate\Http\Request;
use DB;

class segment_structure_infoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function getsegmnets(Request $request)
    {
     $structure_code =  $request->structure_code;
     return   $segment_structure_info = segment_structure_info::with(['segments.segment_details'])->where('structure_code',$structure_code)->get();
    }

    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-segment_structure_info'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $query = segment_structure_info::where('strcture_code', 'LIKE', "%$keyword%")
                ->orWhere('seg_head_id', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->select( 'structure_code' )->distinct('structure_code');
        } else {
            $query = segment_structure_info::select( 'structure_code' )->distinct('structure_code');
        }
         $segment_structure_info = $query->with(['structure.segments'])->paginate($perPage);


        // with(['structure.segments'])->groupBy('structure_code')->paginate($perPage);
        return view('/admin/.segment_structure_info.index', compact('segment_structure_info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-segment_structure_info'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['segment_heads'] =  segment_head::all();
        $data['enumstatus'] = Helper::getEnumValues('segment_structure_infos', 'status');

        return view('/admin/.segment_structure_info.create', $data);
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
     if(!Utility::permissionCheck('create-segment_structure_info'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'strcture_code' => 'required'
		]);
        $requestData = $request->all();


foreach($request->head as $key=>$value) {
    $result = segment_structure_info::updateOrCreate(
        [
            'order_by' => $key,
            'structure_code' => $request->strcture_code,
        ],
        [
            'seg_head_id' => $value['head_id'],
            'status' => $request->status,
        ]);
   // segment_structure_info::create($requestData);
}
        return redirect('admin/segment_structure_info')->with('flash_message', 'segment_structure_info added!');
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
    if(!Utility::permissionCheck('view-segment_structure_info'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

       // $data['segment_structure_info'] = segment_structure_info::findOrFail($id);
        $data['enumstatus'] = Helper::getEnumValues('segment_structure_infos', 'status');
        $data['segment_structure_info'] = segment_structure_info::where('structure_code',$id)->get();
        $data['structure_code'] = $id;

        return view('/admin/.segment_structure_info.show', $data);
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

     if(!Utility::permissionCheck('update-segment_structure_info'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['segment_structure_info'] = segment_structure_info::where('structure_code',$id)->get();
        $data['enumstatus'] = Helper::getEnumValues('segment_structure_infos', 'status');
        $data['segment_heads'] =  segment_head::all();
        $data['structure_code'] = $id;
        return view('/admin/.segment_structure_info.edit', $data);
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

     if(!Utility::permissionCheck('update-segment_structure_info'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'strcture_code' => 'required'
		]);
        $requestData = $request->all();

        foreach($request->head as $key=>$value) {
            if(!empty($value['head_id']))
            $result = segment_structure_info::updateOrCreate(
                [
                    'order_by' => $key,
                    'structure_code' => $request->strcture_code,
                ],
                [
                    'seg_head_id' => $value['head_id'],
                    'status' => $request->status,
                ]);
            // segment_structure_info::create($requestData);
        }
      /*  $segment_structure_info = segment_structure_info::findOrFail($id);
        $segment_structure_info->update($requestData);*/

        return redirect('admin/segment_structure_info')->with('flash_message', 'segment_structure_info updated!');
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
     if(!Utility::permissionCheck('delete-segment_structure_info'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        segment_structure_info::where('structure_code',$id)->delete();

        return redirect('admin/segment_structure_info')->with('flash_message', 'segment_structure_info deleted!');
    }

    public function del_seg_head(Request $request)
    {
        if(!Utility::permissionCheck('delete-segment_structure_info'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        segment_structure_info::destroy($request->id);

        return redirect('admin/segment_structure_info')->with('flash_message', 'segment_structure_info deleted!');
    }
}
