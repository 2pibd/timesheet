<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Utility\Utility;
use App\Models\workflow_template_setting;
use Illuminate\Http\Request;
use App\Models\company_profile;
use App\Models\workflow_setting;
use Auth;
use App\Models\User;
use App\Models\workflow_template_value;
class workflow_template_settingController extends Controller
{

    public function selectApprovalTemplate(Request $request)
    {
        $data['result'] =   workflow_template_setting::with('workflow_template_value','workflow_template_value.setting_value' )->get();
        $data['deal_id'] = $request->deal_id;
        $data['treeuser'] = $this->getTreeUser() ;

        return view('/admin/.agent_deal.approval_template_popup', $data);
    }


    public function getTreeUser($uid = '')
    {
       if(empty($uid)) $uid = Auth::id() ;
     $user = User::where('id', $uid)->with(['present_address'])->first();
        $role =  $user->getRoleNames()->first();
       $phone = $user->phone_no;
      $name =  $user->name ;

   $string =  '{"id": "'.$user->id.'", "parent_id": "'. $user->parent_user_id .'",   "name": "'.   $name .'", "email": "'. $user->email .'","phone": "'. $phone .'", "currency":  "'. $user->currency .'",
                    "address": "'. $user->present_address?->address .'",  "address2": "'. $user->present_address?->address2 .'",   "address3": "'. $user->present_address?->address3 .'",  "address4": "'. $user->present_address?->address4.'", "address5": "'. $user->present_address?->address5 .'",
                    "city": "'. $user->present_address?->city .'", "state": "'. $user->present_address?->state .'",  "post_code": "'.$user->present_address?->zip_code .'",  "country": "'. $user->present_address?->country .'",   "role": "'. $role .'"  },';

            //  $string .= file_get_contents(  url("admin/get_treeviewuser/$uid")  )  ;
        //$string .=  user_info::recruiters_users($uid);

        $string .=  app('App\Http\Controllers\UserController')->get_treeviewuser($uid);

        $string =   @substr($string,0,-1);

        $treeuser =  '[ '. $string .' ]';


        return json_decode($treeuser,true) ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-workflow_template_setting'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $workflow_template_setting = workflow_template_setting::where('user_id', 'LIKE', "%$keyword%")
                ->orWhere('title', 'LIKE', "%$keyword%")
                ->orWhere('ext_ref', 'LIKE', "%$keyword%")
                ->orWhere('company_id', 'LIKE', "%$keyword%")
                ->orWhere('workflow_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $workflow_template_setting = workflow_template_setting::latest()->paginate($perPage);
        }

        return view('/admin/.workflow_template_setting.index', compact('workflow_template_setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */


    public function create()
    {
    if(!Utility::permissionCheck('create-workflow_template_setting'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['companies'] = company_profile::where('user_id',Auth::id())->get();
        $data['workflow_setting'] = workflow_setting::where('user_id',Auth::id())->get();



        $data['treeuser'] = $this->getTreeUser() ;
        return view('/admin/.workflow_template_setting.create', $data);
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
     if(!Utility::permissionCheck('create-workflow_template_setting'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();
        $requestData['user_id'] = Auth::id();
        $result = workflow_template_setting::create($requestData);
        $this->createUpdateTemplateVal($result->id, $request->user);
        return redirect('workflow_template_setting')->with('flash_message', 'workflow_template_setting added!');
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
    if(!Utility::permissionCheck('view-workflow_template_setting'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $workflow_template_setting = workflow_template_setting::findOrFail($id);

        return view('/admin/.workflow_template_setting.show', compact('workflow_template_setting'));
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


         $data['treeuser'] = $this->getTreeUser() ;

     if(!Utility::permissionCheck('update-workflow_template_setting'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

            $data['workflow_template_setting'] = workflow_template_setting::with(['workflow_template_value' ,'workflow_template_value.setting_value'  ])->findOrFail($id);

        $data['companies'] = company_profile::where('user_id',Auth::id())->get();
        $data['workflow_setting'] = workflow_setting::where('user_id',Auth::id())->get();

        return view('/admin/.workflow_template_setting.edit', $data);
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

     if(!Utility::permissionCheck('update-workflow_template_setting'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();

        $workflow_template_setting = workflow_template_setting::findOrFail($id);
        $result =  $workflow_template_setting->update($requestData);

        $this->createUpdateTemplateVal($id, $request->user);

        return redirect('workflow_template_setting')->with('flash_message', 'workflow_template_setting updated!');
    }




    public function createUpdateTemplateVal($template_id, $data)
    {


        foreach($data as $key=>$value) {
            $options = workflow_template_value::updateOrCreate(
                [
                    'id' =>  $value['id'] ,
                    'workflow_template_id' => $template_id,
                ],
                [
                    'workflow_role' => $value['role_id'],
                    'value' => $value['user_id'],
                ]
            );
        }

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
     if(!Utility::permissionCheck('delete-workflow_template_setting'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        workflow_template_setting::destroy($id);

        return redirect('workflow_template_setting')->with('flash_message', 'workflow_template_setting deleted!');
    }
}
