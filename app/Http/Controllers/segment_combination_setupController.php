<?php

namespace App\Http\Controllers;


use App\Helpers\Helper;
use App\Models\client;
use App\Http\Requests;
use App\Models\segment_combination_setup;
use App\Models\segment_combination_setup_value;
use App\Models\segment_combination_user;
use App\Models\segment_combination_user_value;
use App\Models\segment_structure_info;
use App\Utility\Utility;
use Auth;
use DB;
use Illuminate\Http\Request;


class segment_combination_setupController extends Controller
{

    public function segment_details(Request $request)
    {
        if (!Utility::permissionCheck('view-segment_combination_setup')) {
            return back()->with('error', Utility::getPermissionMsg());
        }
        $data = array();
        if(isset($request->seg_com_setup_id)) {
            $data['segment_combination_users'] = segment_combination_user::with(['segment_combosetup',
                'segment_combosetup:id,seg_comb_code,structure_code',
                'header_value:id,seg_com_users_id,head_id,head_value_id', 'header_value.headerdetails:id,seg_code,details', 'header_value.header:id,seg_name'])
                ->select('id', 'seg_combination_setup_id', 'seg_comb_code', 'structure_code')
                ->get();

            $data['segment_combination_headers'] = segment_combination_user_value::where('seg_com_setup_id', $request->seg_com_setup_id)->with('header')->groupBy('head_id')->get();
        }
        return view('/admin/.segment_combination_setup.segment_details',$data);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (!Utility::permissionCheck('view-segment_combination_setup')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

         $keyword = $request->get('search');
         $perPage = 25;

        if (!empty($keyword)) {
            $query = segment_combination_setup::where('seg_comb_code', 'LIKE', "%$keyword%")
                ->orWhere('structure_code', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest();
        } else {
            $query = segment_combination_setup::latest();
        }

            $segment_combination_setup = $query->paginate($perPage);

        return view('/admin/segment_combination_setup.index', compact('segment_combination_setup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (!Utility::permissionCheck('create-segment_combination_setup')) {
            return back()->with('error', Utility::getPermissionMsg());
        }
        $data['enumstatus'] = Helper::getEnumValues('segment_combination_setups', 'status');
        $data['segment_structure_info'] = segment_structure_info::select(DB::raw('structure_code'))->groupBy('structure_code')->get();
        $data['clients'] = client::where('user_id', Auth::id())->get();

        $data['treeuser'] = app('App\Http\Controllers\workflow_template_settingController')->getTreeUser();

        return view('/admin/segment_combination_setup.create', $data);
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
        if (!Utility::permissionCheck('create-segment_combination_setup')) {
            return back()->with('error', Utility::getPermissionMsg());
        }
        $this->validate($request, [
            'seg_comb_code' => 'required',
            'seg_comb_code' => 'required|unique:segment_combination_setups'
        ]);

        DB::transaction(function () use ($request) {
            $requestData = $request->all();
            $segment_combination_setup = segment_combination_setup::create($requestData);

            $seg_combination_setup_id = $segment_combination_setup->id;


            /* foreach ($request->client_id as $com => $client)
                 if($client!='All') {
                     foreach ($request->seg as $k => $seg_val) {
                         foreach ($seg_val['segment_value_id'] as $key => $value)
                             if (!empty($value) && $value!='All')
                                 $result = segment_combination_setup_value::updateOrCreate(
                                     [
                                         'order_by' => $k,
                                         'seg_combination_setup_id' => $seg_combination_setup_id,
                                         'head_id' => $seg_val['head_id'] ,
                                         'client_id' => $client,
                                     ],
                                     [
                                         'segment_value_id' => $value ,
                                         'default_allocated_user' =>  $request->default_allocated_user,
                                     ]);

                     }
                 }*/

            $segArr = array();
            foreach ($request->seg as $k => $seg_val) {
                $fields = array_flip($seg_val['segment_value_id']);
                unset($fields['All']);
                $fields = array_flip($fields);
                if ($seg_val['segment_value_id'] != 'All') $segArr[] = $fields;
            }


            $combinations = $this->get_combinations($segArr);

            /*   foreach ($request->client_id as $com => $client)
                   if($client!='All') {*/
            foreach ($combinations as $com => $combo) {

                foreach ($request->seg as $k => $seg_val) {
                    $entryData['head' . $seg_val['head_id']] = $combo[$k];
                }
                $entryData['seg_combination_setup_id'] = $seg_combination_setup_id;
                //$entryData['client_id'] = $client;
                $entryData['structure_code'] = $segment_combination_setup->structure_code;
                $entryData['seg_comb_code'] = $segment_combination_setup->seg_comb_code;
                // $entryData['default_user_id'] =   $request->default_allocated_user;
                $result = segment_combination_user::updateOrCreate($entryData);

                $parent_id = 0;
                foreach ($request->seg as $k => $seg_val) {
                    /*      segment_combination_header::create([
                            'segment_combination_setup_id' =>$seg_combination_setup_id,
                            'segment_combination_user_id' =>$result->id,
                             'head_id'=>$seg_val['head_id']
                          ]);*/
                    $result2 = segment_combination_user_value::updateOrCreate(
                        [

                            'seg_com_users_id' => $result->id,
                            'head_id' => $seg_val['head_id'],
                        ],
                        [
                            'seg_com_setup_id' => $seg_combination_setup_id,
                            'parent_id' => $parent_id,
                            'head_value_id' => $combo[$k],
                        ]);
                    $parent_id = $result2->id;
                }
            }

            // }

        }, 1);
        // segment_combination_setup::create($requestData);

        return redirect('admin/segment_combination_setup')->with('flash_message', 'segment_combination_setup added!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        if (!Utility::permissionCheck('view-segment_combination_setup')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        $segment_combination_setup = segment_combination_setup::findOrFail($id);

        return view('/admin/.segment_combination_setup.show', compact('segment_combination_setup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {

        if (!Utility::permissionCheck('update-segment_combination_setup')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        $data['clients'] = client::where('user_id', Auth::id())->get();

       $info = $data['info'] = segment_combination_setup::with(['segment_combination_user.seg_heads.segment_details'])->where('id', $id)->first();

        //  return  $data['segments']  =    segment_combination_setup_value::with([  'seg_head.segment_details'])->where('seg_combination_setup_id', $id)-> select(DB::raw('head_id'))->groupBy([ 'head_id'])->get();

          $data['segments'] = segment_structure_info::with(['structure.segments.segment_details:id,seg_head_id,seg_code,details'])->where('structure_code', $info->structure_code)->select('id', 'structure_code')->first();
        //return   $options = DB::select(DB::raw("SELECT h.head_value_id FROM segment_combination_users AS s, segment_combination_user_values AS h WHERE s.id = h.seg_com_users_id AND seg_combination_setup_id = '$id' GROUP BY h.head_value_id"));

            $options = segment_combination_user_value::where('seg_combination_setup_id', $id)
                   ->leftJoin('segment_combination_users','segment_combination_user_values.seg_com_users_id','=','segment_combination_users.id')
                   ->select('head_value_id')->groupBy(['head_value_id'])->get();

        //$options = segment_combination_setup_value::select(DB::raw('segment_value_id'))->where('seg_combination_setup_id', $id)->groupBy(['seg_combination_setup_id','segment_value_id'])->get();

        $options = collect($options);
        $collection = $options->map(function ($item) {
            return $item->head_value_id;
        });
        $data['options'] = $collection->toArray();
        /////////////////////////////////////////////////////////////
        $clientArr = segment_combination_user::select('client_id')->where('seg_combination_setup_id', $info->id)->distinct('client_id')->get();


        $data['segment_combination_users'] = segment_combination_user::with(['segment_combosetup',
            'segment_combosetup:id,seg_comb_code,structure_code',
            'header_value:id,seg_com_users_id,head_id,head_value_id', 'header_value.headerdetails:id,seg_code,details', 'header_value.header:id,seg_name'])
            ->where('seg_combination_setup_id', $info->id)
            ->select('id', 'seg_combination_setup_id', 'seg_comb_code', 'structure_code')
            ->get();
        //  $data['segment_combination_headers']= segment_combination_header::with(['seg_heads:id,seg_name'])->where('segment_combination_setup_id', $info->id)->get();

        //segment_combination_setup_value::select('client_id')->where('seg_combination_setup_id', $info->id)->distinct('client_id')->get();

        $collection = $clientArr->map(function ($item) {
            return $item['client_id'];
        });
        $data['selectclient'] = $collection->toArray();

///////////////////////////////////////////////////////////////
        $data['segment_structure_info'] = segment_structure_info::select(DB::raw('structure_code'))->groupBy('structure_code')->get();

        $data['enumstatus'] = Helper::getEnumValues('segment_combination_setups', 'status');

        $data['treeuser'] = app('App\Http\Controllers\workflow_template_settingController')->getTreeUser();
        $data['segment_combination_headers'] = segment_combination_user_value::where('seg_com_setup_id', $id)->with('header')->groupBy('head_id')->get();

        return view('/admin/.segment_combination_setup.edit', $data);
    }

    public function loadCombinationSegmentData(Request $request)
    {

        $setup_id = $request->setup_id;
        $data['clientObj'] = segment_combination_setup_value::with(['clients' => function ($q) {
            $q->select('company_name', 'id');
        }])->where('seg_combination_setup_id', $setup_id)->select(DB::raw('client_id'))->groupBy('client_id')->get();


        $client = $data['clientObj'][0]->client_id;
        $data['headObj'] = segment_combination_setup_value::with(['seg_head:id,seg_name', 'com_head_value' => function ($q) use ($setup_id, $client) {
            $q->with(['com_head_seg_detail' => function ($q2) use ($client) {
                $q2->select('id', 'details');
            }])->select('id', 'head_id', 'segment_value_id')->where('seg_combination_setup_id', $setup_id)->where('client_id', $client);
            //distinct( 'segment_value_id') ;
        }])
            ->where('seg_combination_setup_id', $setup_id)->select(DB::raw('head_id', 'seg_combination_setup_id'))->groupBy('head_id', 'seg_combination_setup_id')->get();


        /* $data['headObj'] =  segment_combination_setup_value::with(['seg_head:id,seg_name','com_head_value'=>function($q2) use($setup_id) {
              $q2->with(['com_head_value'  =>function($q3) use($setup_id) {
                   $q3->with(['com_head_seg_detail'=>function($q){
                       $q->select('id','details');
                   }])->select('segment_value_id' ,'head_id')->where('seg_combination_setup_id', $setup_id)->distinct( 'head_id, seg_combination_setup_id')  ;
              } ] )->where('seg_combination_setup_id', $setup_id)->select('id ,head_id,segment_value_id')->select( DB::raw('head_id', 'segment_value_id') )->groupBy('head_id'  )->first();

              }])->where('seg_combination_setup_id', $setup_id)->select(DB::raw('head_id') )->groupBy('head_id')->get();*/

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function get_combinations($arrays)
    {
        $result = array(array());
        foreach ($arrays as $property => $property_values) {
            $tmp = array();
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, array($property => $property_value));
                }
            }
            $result = $tmp;
        }
        return $result;
    }


    public function update(Request $request, $id)
    {

        if (!Utility::permissionCheck('update-segment_combination_setup')) {
            return back()->with('error', Utility::getPermissionMsg());
        }


        $this->validate($request, [
            'seg_comb_code' => 'required'
        ]);

        // return $request->seg;

        DB::transaction(function () use ($request, $id) {
            $requestData = $request->all();
            $segment_combination_setup = segment_combination_setup::findOrFail($id);
            // $old_allocated_user = @explode(',',$segment_combination_setup->allocated_user);


            // $diff_user =   array_diff($old_allocated_user, $request->allocated_user);

            /* if( $segment_combination_setup->structure_code != $request->structure_code){
                 segment_combination_setup_value::where('seg_combination_setup_id',$id)->delete();
             }*/

            //$requestData['allocated_user'] = @implode(',',$request->allocated_user['user_id']);

            $segment_combination_setup->update($requestData);


            $segArr = array();
            foreach ($request->seg as $k => $seg_val) {
                $fields = array_flip($seg_val['segment_value_id']);
                unset($fields['All']);
                $fields = array_flip($fields);
                if ($seg_val['segment_value_id'] != 'All') $segArr[] = $fields;
            }


            $combinations = $this->get_combinations($segArr);

            /* $combinations = $this->get_combinations(
                 array(
                     'item1' => array('A', 'B'),
                     'item2' => array('C', 'D'),
                     'item3' => array('E', 'F'),
                 )
             );*/

            // return $combinations;
            /* foreach ($request->client_id as $com => $client)
              if($client!='All') {*/
            foreach ($combinations as $com => $combo) {

                foreach ($request->seg as $k => $seg_val) {
                    $entryData['head' . $seg_val['head_id']] = $combo[$k];
                }
                $entryData['seg_combination_setup_id'] = $id;
                // $entryData['client_id'] =$client;
                $entryData['structure_code'] = $segment_combination_setup->structure_code;
                $entryData['seg_comb_code'] = $segment_combination_setup->seg_comb_code;
                //  $entryData['default_user_id'] =   $request->default_allocated_user;
                $result = segment_combination_user::updateOrCreate($entryData);

                $parent_id = 0;
                foreach ($request->seg as $k => $seg_val) {
                    $result2 = segment_combination_user_value::updateOrCreate(
                        [
                            'seg_com_users_id' => $result->id,
                            'head_id' => $seg_val['head_id'],
                        ],
                        [
                            'seg_com_setup_id' => $id,
                            'parent_id' => $parent_id,
                            'head_value_id' => $combo[$k],
                        ]);
                    $parent_id = $result2->id;
                }
            }

            //  }


        }, 1);

        return redirect('admin/segment_combination_setup')->with('flash_message', 'segment_combination_setup updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        if (!Utility::permissionCheck('delete-segment_combination_setup')) {
            return back()->with('error', Utility::getPermissionMsg());
        }


        segment_combination_setup::where('seg_comb_code', $id)->delete();
        return redirect('admin/segment_combination_setup')->with('flash_message', 'segment_combination_setup deleted!');
    }

    public function delete_segment_combination_user(Request $request, $id)
    {
        if (!Utility::permissionCheck('delete-segment_combination_setup')) {
            return back()->with('error', Utility::getPermissionMsg());
        }


        segment_combination_user::where('id', $id)->delete();
        return redirect('admin/segment_combination_setup/' . $request->segment_combination_setup_id . '/edit')->with('flash_message', 'segment_combination_setup deleted!');
    }

}
