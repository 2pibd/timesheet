<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\segment_combination_setup;
use App\segment_combination_setup_value;
use App\Utility\Utility;
use App\segment_user_allocation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class segment_user_allocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-segment_user_allocation'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $segment_user_allocation = segment_user_allocation::where('seg_combination_setup_id', 'LIKE', "%$keyword%")
                ->orWhere('user_id', 'LIKE', "%$keyword%")
                ->orWhere('start_date', 'LIKE', "%$keyword%")
                ->orWhere('end_date', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $segment_user_allocation = segment_user_allocation::latest()->paginate($perPage);
        }

        return view('/admin/.segment_user_allocation.index', compact('segment_user_allocation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-segment_user_allocation'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $data['treeuser'] = app('App\Http\Controllers\workflow_template_settingController')->getTreeUser() ;
        $data['segment_combo'] = segment_combination_setup::all();
        return view('/admin/.segment_user_allocation.create', $data);
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
     if(!Utility::permissionCheck('create-segment_user_allocation'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'seg_combination_setup_id' => 'required'
		]);
         $requestData = $request->all();

        $query =   segment_combination_setup_value::where('seg_combination_setup_id', $request->seg_combination_setup_id);
        if($request->client_id){
            $query = $query->whereIn('client_id', $request->client_id);
        }
        if($request->segment_val){
            $query = $query->whereIn('segment_value_id', $request->segment_val);
        }
        $result = collect($query->select('id')->get());

//segment_val
        if($result)
        foreach($result as $k  => $seg) {
            foreach ($request->allocated_user as $key => $value) {
                if (!empty($value))
                    $result = segment_user_allocation::updateOrCreate(
                        [
                            'seg_combination_setup_id' => $seg->id,
                            'user_id' => $value['user_id'],
                        ],
                        [
                            'start_date' => Carbon::createFromFormat('d/m/Y', $value['start_date'])->format('Y-m-d'),
                            'end_date' => Carbon::createFromFormat('d/m/Y', $value['end_date'])->format('Y-m-d'),
                        ]);

            }
            $defaultUser['default_allocated_user'] = $request->default_allocated_user;
            segment_combination_setup_value::where('id',  $seg->id)->update( $defaultUser );
        }

        return redirect('segment_user_allocation')->with('flash_message', 'segment_user_allocation added!');
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
    if(!Utility::permissionCheck('view-segment_user_allocation'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $segment_user_allocation = segment_user_allocation::findOrFail($id);

        return view('/admin/.segment_user_allocation.show', compact('segment_user_allocation'));
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

     if(!Utility::permissionCheck('update-segment_user_allocation'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['segment_user_allocation'] = segment_user_allocation::findOrFail($id);
        $data['treeuser'] = app('App\Http\Controllers\workflow_template_settingController')->getTreeUser() ;

        return view('/admin/.segment_user_allocation.edit', $data);
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

     if(!Utility::permissionCheck('update-segment_user_allocation'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'seg_combination_setup_id' => 'required',
			'user_id' => 'required'
		]);
        $requestData = $request->all();

        $segment_user_allocation = segment_user_allocation::findOrFail($id);
        $segment_user_allocation->update($requestData);

        return redirect('segment_user_allocation')->with('flash_message', 'segment_user_allocation updated!');
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
     if(!Utility::permissionCheck('delete-segment_user_allocation'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        segment_user_allocation::destroy($id);

        return redirect('segment_user_allocation')->with('flash_message', 'segment_user_allocation deleted!');
    }
}
