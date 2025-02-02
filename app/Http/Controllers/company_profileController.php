<?php

namespace App\Http\Controllers;

use App\Models\agent_jobs_candidate_todo_list;

use App\Models\company_address;
use App\Models\company_compliance;
use App\Models\company_contact_email;
use App\Models\company_contact_info;
use App\Models\company_contact_info_phone;
use App\Models\company_division;
use App\Models\company_head;
use App\Models\company_head_details;
use App\Models\company_profile;
use App\Models\compliance;
use App\Models\compliance_group;
use App\Models\compliance_group_combination;
use App\Models\compliance_sector;
use App\Models\compliance_type;
use App\Models\country;
use App\Models\currency;
use App\Helpers\Helper;
use App\Http\Requests;
use App\Models\industry;
use App\Models\language;
use App\Models\name_title;
use App\Models\User;
use App\Utility\Utility;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use  Image;
use Illuminate\Support\Facades\Gate;
use DB;

use Illuminate\Support\Facades\Storage;
class company_profileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request)
    {

        if (!Utility::permissionCheck('view-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }


 /*
   $dir = "company_logo/";

      $fileFolderList = scandir(public_path($dir));
  foreach ($fileFolderList as $fileFolder) {
            if ($fileFolder != '.' && $fileFolder != '..'){
                 $file =   $dir . '/' . $fileFolder;
               $destination = public_path($dir . '/' . $fileFolder) ;
               $contents = \File::get($destination);
               Storage::disk('s3')->put( "company/company_logo/".$fileFolder, $contents);
               }
   }
exit;
*/







        //////start column wise head //
        $data['columns'] = $columns = Helper::showColumn('company_profile');

        $data['treeuser'] = app('App\Http\Controllers\workflow_template_settingController')->getTreeUser(); //User::where('parent_user_id', Auth::id() )->get();

////////////////end column wise view
        return view('/admin/.company_profile.default', $data);
    }


    public function loadCompanyProfile(Request $request)
    {
         $data['company_profile'] = company_profile::where('id', $request->id)->first();
       // $data['contact_details'] = company_contact_info::with('company')->where('company_id', $request->id)->get();
        $data['contact_info'] = company_contact_info::where('company_id', $request->id)->get();
        $data['address'] = company_address::with('CountryLoad', 'StateLoad', 'CityLoad')->where('company_id', $request->id)->get();

        return view('/admin/.company_profile.loadCompanyProfile', $data);
    }

    public function getClientList(Request $request)
    {
        $heads = $request->Gobjects;
        $html = '';
        @ini_set('memory_limit', '1024M');
        @ini_set('max_execution_time', 840);



        if ($request->user_id) $uid = $request->user_id; //else  $uid = Auth::id();


        $query = company_profile::latest()->where('deleteitem','0');

        if(!empty($uid)) $query =   $query->where('user_id', $uid)->latest();

/*        if (isset($request->keyword) ) {
            $query =   $query->where(function($query) use ($request){
                $query->where('company_name', 'LIKE', '%'.$request->keyword.'%');
                $query->orWhere('company_email', 'LIKE', '%'.$request->keyword.'%');
                $query->orWhere('company_phone', 'LIKE', '%'.$request->keyword.'%');
                $query->orWhere('id',  $request->keyword);
            });
        }*/


        if(!empty($request->search_field) && !empty($request->search_keyword)){
            if($request->search_field == 'postby'){
                $query = $query->whereHas('postby',function($q) use($request){
                    $q = $q->WhereRaw('CONCAT_WS(" ", trim(name_title), trim(name), trim(middle_name), trim(last_name)) like "%' . $request->search_keyword  . '%"');

                });
            }else
                if($request->search_field == 'client'){
                    $query = $query->whereHas('placement_company',function($q) use($request){
                        $q->where('company_name', 'LIKE' , "%". $request->search_keyword ."%");
                    });
                }else
                    $query = $query->where($request->search_field, 'LIKE' , "%". $request->search_keyword ."%");
        }



        if(Utility::permissionCheck('all-company_job')  && $request->user_id == '')
        {
            $query = $query;
        }elseif(Utility::permissionCheck('team-company_job') && $request->user_id == 'team') {
            $userIds = app('App\Http\Controllers\adminControllers\adminController')->treeUserIDs(Auth::id()) ;
            //$queryCom =   $queryCom->whereIn('user_id', $userIds);

            $query = $query->where(function($q) use($userIds)  {
                $q->whereIn('user_id', $userIds);
                $q->oRwhereHas('agent_assign_company', function($q2){
                    $q2->where('assign_user', Auth::id());
                });
            });
        }elseif(Utility::permissionCheck('self-company_job') && !Utility::permissionCheck('all-company_job'))
        {
            $query = $query->where(function($q)  {
                $q ->where('user_id', Auth::id());
                $q->oRwhereHas('agent_assign_company', function($q2){
                    $q2->where('assign_user', Auth::id());
                });
            });
        }

        if (isset($request->todate) && isset($request->fromdate)) {
            $todate = (isset($request->todate)) ? Carbon::createFromFormat('d/m/Y', $request->todate)->format('Y-m-d') : '';
            $fromdate = (isset($request->fromdate)) ? Carbon::createFromFormat('d/m/Y', $request->fromdate)->format('Y-m-d') : '';
            $query = $query->whereBetween('created_at', [$fromdate, $todate]);
        }elseif (isset($request->todate)) {
            $todate = (isset($request->todate)) ? Carbon::createFromFormat('d/m/Y', $request->todate)->format('Y-m-d') : '';
            $now = Carbon::now();
            $query = $query->whereBetween('created_at', [$now, $todate]);
        } elseif (isset($request->fromdate)) {
            $fromdate = (isset($request->fromdate)) ? Carbon::createFromFormat('d/m/Y', $request->fromdate)->format('Y-m-d') : '';
            $now = Carbon::now();
            $query = $query->whereBetween('created_at', [$fromdate, $now]);
        }


        if ($request->searchfilter == 'Weekly') {
            $now = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');
            $query = $query->whereBetween('created_at', [$weekStartDate, $weekEndDate]);
        }


        if ($request->searchfilter == 'Monthly') {
            $currentMonth = date('m');
            $query = $query->whereMonth('created_at', $currentMonth);
        }


        if ($request->searchfilter == 'ThreeMonths') {
            $now = Carbon::now();
            $EndDate = $now->startOfMonth()->format('Y-m-d');
            $StartDate = $now->startOfMonth()->subMonth(3)->format('Y-m-d');
            $query = $query->whereBetween('created_at', [$StartDate, $EndDate]);
        }


        if ($request->searchfilter == '6months') {
            $now = Carbon::now();
            $EndDate = $now->startOfMonth()->format('Y-m-d');
            $StartDate = $now->startOfMonth()->subMonth(6)->format('Y-m-d');
            $query = $query->whereBetween('created_at', [$StartDate, $EndDate]);

        }

        if ($request->searchfilter == 'Yearly') {
            $currentYear = date('Y');
            $query = $query->whereYear('created_at', $currentYear);
        }



      $Result = $query->withCount(['company_contact_parson', 'vacancy', 'candidate', 'placement','company_billing_address'])->with(['company_contact_parson' => function ($q1) {
            $q1->where('is_default', 1)->get();
        }])->skip($request->start)->take($request->limit)->get();


        //$Result = job_post::skip($request->start)->take($request->limit)->get();
        foreach ($Result as $item) {
            $html .= '<tr class="selectItem"  data-id="' . $item->id . '"    > ';
            foreach ($heads as $key => $head)
                if ($head['data'] == 'option') {
                    $html .= '<td class="class_' . $key . '"><input type="checkbox" name="selectItem[]" class="selectItemCheckbox" data-id="' . $item->id . '"  value="' . $item->id . '"   >';

                    $html .= '<a href="javascript:;" class="pull-right viewBtn"  data-id="' . $item->id . '"   data-toggle="tooltip"
                                                   data-original-title="Profile Summary"><i class="fab fa-readme" style="font-size: 22px"></i></a></td>';

                } elseif ($head['data'] == 'postby') {
                    $profile = '';
                    $profile .= (!empty($item->postby->name_title)) ? $item->postby->name_title . ' ' : '';
                    $profile .= (!empty($item->postby->name)) ? $item->postby->name . ' ' : '';
                    $profile .= (!empty($item->postby->middle_name)) ? $item->postby->middle_name . ' ' : '';
                    $profile .= (!empty($item->postby->last_name)) ? $item->postby->last_name . ' ' : '';
                    $html .= '<td class="class_' . $key . '"  >' . $profile . '</td>';
                } else {
                    $html .= '<td class="class_' . $key . '"  >' . $item[$head['data']] . '</td>';
                }

            $html .= '</tr>';

        }
        echo $html;
    }

    public function getClientListForDeal(Request $request)
    {
        if ($request->user_id) $uid = $request->user_id; //else  $uid = Auth::id();
/*     $data['treeuser'] = app('App\Http\Controllers\workflow_template_settingController')->getTreeUser(); //User::where('parent_user_id', Auth::id() )->get();

        if (!empty($request->user_id)) {
            $chk_user = 0;
            foreach ($data['treeuser'] as $key => $item)
                if ($item['id'] == $uid) $chk_user = 1;

            if ($chk_user == 0) return redirect('job_post')->with('flash_message', 'You have no permission to visit!');
        }*/


        $query = company_profile::latest()->where('deleteitem','0');

        if(!empty($uid)) $query =   $query->where('user_id', $uid)->latest();

        if (isset($request->client_id) ) {
            $query =   $query->where('id', $request->client_id) ;
        }

        if(Utility::permissionCheck('all-company_job')  && $request->user_id == '')
        {
            $query = $query;
        }elseif(Utility::permissionCheck('team-company_job') && $request->user_id == 'team') {
            $userIds = app('App\Http\Controllers\adminControllers\adminController')->treeUserIDs(Auth::id()) ;
            //$queryCom =   $queryCom->whereIn('user_id', $userIds);

            $query = $query->where(function($q) use($userIds)  {
                $q->whereIn('user_id', $userIds);
                $q->oRwhereHas('agent_assign_company', function($q2){
                    $q2->where('assign_user', Auth::id());
                });
            });
        }elseif(Utility::permissionCheck('self-company_job'))
        {
            $query = $query->where(function($q)  {
                $q ->where('user_id', Auth::id());
                $q->oRwhereHas('agent_assign_company', function($q2){
                    $q2->where('assign_user', Auth::id());
                });
            });
        }

        if (isset($request->todate) && isset($request->fromdate)) {
            $todate = (isset($request->todate)) ? Carbon::createFromFormat('d/m/Y', $request->todate)->format('Y-m-d') : '';
            $fromdate = (isset($request->fromdate)) ? Carbon::createFromFormat('d/m/Y', $request->fromdate)->format('Y-m-d') : '';
            $query = $query->whereBetween('created_at', [$fromdate, $todate]);
        }elseif (isset($request->todate)) {
            $todate = (isset($request->todate)) ? Carbon::createFromFormat('d/m/Y', $request->todate)->format('Y-m-d') : '';
            $now = Carbon::now();
            $query = $query->whereBetween('created_at', [$now, $todate]);
        } elseif (isset($request->fromdate)) {
            $fromdate = (isset($request->fromdate)) ? Carbon::createFromFormat('d/m/Y', $request->fromdate)->format('Y-m-d') : '';
            $now = Carbon::now();
            $query = $query->whereBetween('created_at', [$fromdate, $now]);
        }




        if ($request->searchfilter == 'Weekly') {
            $now = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');
            $query = $query->whereBetween('created_at', [$weekStartDate, $weekEndDate]);
        }


        if ($request->searchfilter == 'Monthly') {
            $currentMonth = date('m');
            $query = $query->whereMonth('created_at', $currentMonth);
        }


        if ($request->searchfilter == 'ThreeMonths') {
            $now = Carbon::now();
            $EndDate = $now->startOfMonth()->format('Y-m-d');
            $StartDate = $now->startOfMonth()->subMonth(3)->format('Y-m-d');
            $query = $query->whereBetween('created_at', [$StartDate, $EndDate]);
        }


        if ($request->searchfilter == '6months') {
            $now = Carbon::now();
            $EndDate = $now->startOfMonth()->format('Y-m-d');
            $StartDate = $now->startOfMonth()->subMonth(6)->format('Y-m-d');
            $query = $query->whereBetween('created_at', [$StartDate, $EndDate]);

        }

        if ($request->searchfilter == 'Yearly') {
            $currentYear = date('Y');
            $query = $query->whereYear('created_at', $currentYear);
        }



        $clientData = $query->withCount(['company_contact_parson', 'vacancy', 'candidate', 'placement','company_billing_address'])->with(['company_contact_parson' => function ($q1) {
            $q1->where('is_default', 1)->get();
        }])->get();


        return datatables()->of($clientData)

            ->addColumn('option', function ($data) {
                $option = '';

                if (Gate::allows('shortnav' )) {
                    $option = ' <input type="hidden" class="selectItem"  data-id="'.$data->id.'"  value="'.$data->id.'"       >';

                   /* $option =  '<div class="radio">
                                                <label class="i-checks"><input class="custom-radio selectItem" type="radio" id="radio_1" name="select"  data-id="'.$data->id.'"  value="' . $data->id . '" >
                                                    <i></i>
                                                </label>
                                            </div>';*/
                }
                $option .=  '<div class="  btn-group " role="group">
                                    <button type="button"
                                            class="btn btn-primary btn-xs btn-flat ng-scope dropdown-toggle statusbtn"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-asterisk" data-toggle="tooltip"
                                           data-original-title="Order Status"></i> <span class="caret"></span>
                                    </button>


                                    <ul class="dropdown-menu">

                                        <li style="cursor:pointer; padding:5px 10px; border-bottom:1px solid #ccc;">


                                        <li style="cursor:pointer; padding:5px 10px; border-bottom:1px solid #ccc;">
                                            <a href="'.url('company_profile/'. $data->id.'/edit').'"  class="p-0 no-padder">
                                                   <button class="btn btn-primary btn-xs  btn-block p-0"  title="Edit job_post"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>
                                            </a>




                                        <li style="cursor:pointer; padding:5px 10px; border-bottom:1px solid #ccc;">
                                            <form method="POST" action="'.url('company_profile', $data->id).'" id="deljob" accept-charset="UTF-8"
                                                  style="display:inline">'.
                    method_field('DELETE'). csrf_field() .'
                                                <button type="submit" class="btn btn-primary btn-xs btn-block"
                                                        title="Delete job_post"
                                                        onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                                                        class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                </button>
                                            </form>
                                        </li>


                                    </ul>
                                </div>';

                $option .='<a href="javascript:;" class="pull-right viewBtn"   data-id="'.$data->id.'"  ><i class="fa fa-binoculars"></i></a>';
                return $option;
            })


            ->addColumn('comp_name', function ($data) {
                $company =   $data->company_name  ;
                return $company;
            })
            ->addColumn('total_vacancy', function ($data) {
                return $data->vacancy_count;
            })
            ->addColumn('total_candidate', function ($data) {
                return $data->candidate_count;
            })
            ->addColumn('total_placement', function ($data) {
                return $data->placement_count;
            })
            ->addColumn('total_billing_address', function ($data) {
                return $data->company_billing_address_count;
            })


            ->addColumn('total_contact', function ($data) {
                return $data->company_contact_parson_count;
            })
            ->addColumn('contact_name', function ($data) {
                return (isset($data->company_contact_parson[0]->contact_name)) ? $data->company_contact_parson[0]->contact_name . ', ' : '';
            })
            ->addColumn('action', function ($data) {
                $button = '<a href="' . url('/admin/company_profile/' . $data->id . '/edit') . '"
               title="Edit company_profile">
                <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"
                                                          aria-hidden="true"></i>
                </button>
            </a>

            <form method="POST"
                  action="' . url('/admin/company_profile/' .  $data->id ) .'"   accept-charset="UTF-8" style="display:inline">
                ' . method_field('DELETE') . csrf_field()
                    . '<button type="submit" class="btn btn-danger btn-xs"
                        title="Delete company_profile"
                        onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                        class="fa fa-trash-o" aria-hidden="true"></i></button>
            </form>';

                return $button;
            })
            ->rawColumns(['action', 'comp_name','option'])
            ->make(true);
    }

    public function contact_details(Request $request)
    {
        $query = company_address::with('company');

        if(Utility::permissionCheck('self-company_profiles'))
        {
            $query = $query->whereHas('company', function($q) {
                $q->where('user_id', Auth::id());
            });
        }
        $data['contact_details'] =$query->get();

        return view('/admin/company_profile.contact_details', $data);
    }


    public function fetch_clientData(Request $request)
    {
        if ($request->ajax()) {
            //  return $request;


            $perPage = 10;
            $query = company_profile::where('user_id', Auth::id())->latest();

            $keywordCreated_at = (isset($request->created_at)) ? Carbon::createFromFormat('d/m/Y', $request->created_at)->format('Y-m-d') : '';
            if (!empty($keywordCreated_at)) {
                $query = $query->whereDate('created_at', $keywordCreated_at);
            }

            $keywordclient_id = $request->get('client');
            if (!empty($keywordclient_id)) {
                $query = $query->where('company_name', 'LIKE', "%$keywordclient_id%")->orWhere('company_id', $keywordclient_id);
            }

            $keywordPhone = $request->get('phone');
            if (!empty($keywordPhone)) {
                $query = $query->where('company_phone', $keywordPhone);
            }

            $data['company_profile'] = $query->withCount(['company_contact_parson', 'company_billing_address', 'vacancy', 'candidate', 'placement'])->with(['company_contact_parson' => function ($q1) {
                $q1->where('is_default', 1)->get();
            }, 'company_billing_address' => function ($q2) {
                $q2->where('is_default', 1)->get();
            }])->get()->paginate($perPage);
            //////start column wise head /////

            $clientdata = array();
            $data['columns'] = $columns = Helper::showColumn('company_profile');


            $data['headers'] = $columns->setup_version;
            $header = $columns->user_items;
            foreach ($data['company_profile'] as $key => $item) {
                $temdata = ([
                    'id' => $item->id,
                    'comp_name' => $item->company_name,
                    'comp_email' => $item->company_email,
                    'phone' => $item->company_phone,

                    'contact_name' => (isset($item->company_contact_parson[0]->contact_name)) ? $item->company_contact_parson[0]->contact_name . ', ' : '',
                    'address' => (isset($item->company_billing_address[0]->address1)) ? $item->company_billing_address[0]->address1 : '',
                    'address2' => (isset($item->company_billing_address[0]->address2)) ? $item->company_billing_address[0]->address2 : '',
                    'address3' => (isset($item->company_billing_address[0]->address3)) ? $item->company_billing_address[0]->address3 : '',
                    'address4' => (isset($item->company_billing_address[0]->address4)) ? $item->company_billing_address[0]->address4 : '',
                    'address5' => (isset($item->company_billing_address[0]->address5)) ? $item->company_billing_address[0]->address5 : '',

                    'city' => (isset($item->company_billing_address[0]->city)) ? $item->company_billing_address[0]->city : '',
                    'state' => (isset($item->company_billing_address[0]->state)) ? $item->company_billing_address[0]->state : '',
                    'postcode' => (isset($item->company_billing_address[0]->postcode)) ? $item->company_billing_address[0]->postcode : '',
                    'country' => (isset($item->company_billing_address[0]->country)) ? $item->company_billing_address[0]->country : '',

                    'total_vacancy' => $item->vacancy_count,
                    'total_candidate' => $item->candidate_count,
                    'total_placement' => $item->placement_count,
                    'total_billing_address' => $item->company_billing_address_count,
                    'total_contact' => $item->company_contact_parson_count,
                    'currency' => $item->default_currency,
                    'language' => $item->default_lang,
                    'created_at' => $item->created_at,
                    'company_id' => $item->company_id,
                    'vat_id' => $item->vat_reg,
                ]);

                foreach ($header as $head => $name)
                    $clientdata[$key][$name->field] = $temdata[$name->field];
                $clientdata[$key]['id'] = $item->id;
            }


            $data['clientdata'] = isset($clientdata) ? collect($clientdata) : '';
////////////////end column wise view
            return view('/admin/company_profile.client_data', $data);
        }
    }

    public function export_client_excel(Request $request)
    {

        if (!empty($request)) {

            if (!Utility::permissionCheck('view-company_profiles')) {
                return back()->with('error', Utility::getPermissionMsg());
            }


            $query = company_profile::where('user_id', Auth::id())->latest();

            $keywordCreated_at = (isset($request->created_at)) ? Carbon::createFromFormat('d/m/Y', $request->exp_created_at)->format('Y-m-d') : '';
            if (!empty($keywordCreated_at)) {
                $query = $query->whereDate('created_at', $keywordCreated_at);
            }

            $keywordclient_id = $request->get('exp_client');
            if (!empty($keywordclient_id)) {
                $query = $query->where('company_name', 'LIKE', "%$keywordclient_id%")->orWhere('company_id', $keywordclient_id);
            }


            $keywordPhone = $request->get('exp_phone');
            if (!empty($keywordPhone)) {
                $query = $query->where('company_phone', $keywordPhone);
            }
            $data['company_profile'] = $query->withCount(['company_contact_parson', 'company_billing_address', 'vacancy', 'candidate', 'placement'])->with(['company_contact_parson' => function ($q1) {
                $q1->where('is_default', 1)->first();
            }, 'company_billing_address' => function ($q2) {
                $q2->where('is_default', 1)->first();
            }])->get(); //paginate($perPage);


            //////start column wise head /////
            $clientdata = array();
            $data['columns'] = $columns = Helper::showColumn('company_profile');

            $header = $columns->user_items;


            foreach ($data['company_profile'] as $key => $item) {
                $address = '';

                $address .= (isset($item->company_billing_address[0]->address1)) ? $item->company_billing_address[0]->address1 : '';
                $address .= (isset($item->company_billing_address[0]->city)) ? $item->company_billing_address[0]->city . ', ' : '';
                $address .= (isset($item->company_billing_address[0]->state)) ? $item->company_billing_address[0]->state . ', ' : '';


                $temdata = ([
                    'id' => $item->id,
                    'comp_name' => $item->company_name,
                    'comp_email' => $item->company_email,
                    'phone' => $item->company_phone,
                    'contact_name' => (isset($item->company_contact_parson[0]->contact_name)) ? $item->company_contact_parson[0]->contact_name . ', ' : '',
                    'address' => $address,
                    'total_vacancy' => $item->vacancy_count,
                    'total_candidate' => $item->candidate_count,
                    'total_placement' => $item->placement_count,
                    'total_billing_address' => $item->company_billing_address_count,
                    'total_contact' => $item->company_contact_parson_count,
                    'currency' => $item->default_currency,
                    'language' => $item->default_lang,
                    'created_at' => $item->created_at,
                    'company_id' => $item->company_id,
                    'vat_id' => $item->vat_reg,
                ]);


                /*foreach ($header as $head => $name)
                    $clientdata[$key][$name->field] = $temdata[$name->field];*/


                foreach ($request->columns as $head)
                    $clientdata[$key][$head] = $temdata[$head];

            }

            $clientdata = collect($clientdata);
            $columnsData[] = $request->columns;

            foreach ($header as $head => $name)
                $headtitle[] = $name->title;
            //$columnsData[] = $headtitle;

            foreach ($clientdata as $key => $item) {
                $columnsData[] = $item;
            }


            // dd($columnsData);
            Excel::create('Client_List', function ($excel) use ($columnsData) {
                $excel->setTitle('Client List');
                $excel->sheet('Client List', function ($sheet)
                use ($columnsData) {
                    $sheet->fromArray($columnsData, null, 'A1', false, false);
                });
            })->download('xlsx');
            // return collect($columnsData);
        }

        /////////////////New///
        // return $request;
        //$columns=   $request->columns;
        // return Excel::download(new ClientExport($request),  'users.xlsx' );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        if (!Utility::permissionCheck('create-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }
        $data['currency'] = currency::get();
        $data['country'] = country::where('lang', 'en')->get();
        $data['industry'] = industry::where('lang', 'en')->orderBy('industry')->where('lang','en')->get();
        $data['allTabActive'] = false;
        $data['param'] = 0;
        $data['languages'] = language::where('display_default', '1')->get();

        $data['compliance_groups'] = compliance_group::get();
        $data['status'] = Helper::getEnumValues('company_profiles','status');

        return view('/admin/.company_profile.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        if (!Utility::permissionCheck('create-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        $this->validate($request, [
            'company_name' => 'required'
        ]);

        $title_str                   = $request->company_name;
        $title                       = str_replace("'", '', $title_str);

        $requestData                 = $request->all();
        $requestData['company_name'] = $title;

        $requestData['user_id']      = Auth::id();


        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $name = time() . '_' . $image->getClientOriginalName();
            //$destinationPath = public_path('company_logo');
            $base_path = '/company_logo/';
            #$destinationPath =  public_path($base_path);
            #$imagePath = $destinationPath . "/" . $name;
            //$image->move($destinationPath, $name);

            $image->storeAs('company/company_logo/', $name ,'s3');

            $requestData['company_logo'] = $base_path.$name;
            $requestData['base_path'] = $base_path;
            $requestData['base_url'] = asset('');
        }


       /* if ($request->hasFile('file')) {
            $image = $request->file('file');
            // $name =    time() . '.' . $image->getClientOriginalExtension();
            $name    =  'logo_'.time().$image->getClientOriginalName();

            $path =    '/company_logo/';
            $destinationPath = public_path($path);
            $imagePath = $destinationPath .  $name;
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(200, 200);
            $image_resize->save($imagePath);

            //$image->move($destinationPath, $name);
            $requestData['company_logo'] = $path.$name;
            $requestData['base_url'] = asset('');
        }*/

        $result = company_profile::create($requestData);

        $id = $result->id;


        return redirect('company_profile/' . $id . '/edit')->with('flash_message', 'company_profile added!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return View
     */
    public function show($id)
    {
        if (!Utility::permissionCheck('view-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        $company_profile = company_profile::findOrFail($id);

        return view('/admin/.company_profile.show', compact('company_profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return View
     */
    public function company_options($id)
    {

        if (!Utility::permissionCheck('update-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        $data['cid'] = $id;
        $data['options'] = company_head::where('company_id', $id)->get();
        $data['company_profile'] = company_profile::with(['header'])->findOrFail($id);
        // $data['results'] = company_head_details::with(['options'])->where('company_id', $id)->get();
        return view('/admin/.company_profile.company_options', $data);
    }


    public function load_company_options(Request $request)
    {

        if (!Utility::permissionCheck('update-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }
        $data['currency'] = currency::get();
        $data['cid'] = $request->cid;
        $data['company_profile'] = company_profile::with(['header'])->findOrFail($request->cid);
        $data['results'] = company_head_details::with(['options'])->where('company_id', $request->cid)->get();


        return view('/admin/.company_profile.load_company_options', $data);
    }


    public function save_head_options(Request $request)
    {


        if (!Utility::permissionCheck('create-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }


        $this->validate($request, [
            'title' => 'required'
        ]);
        $requestData = $request->all();


        // agent_jobs_candidate_todo_list::create($requestData);
        $result = company_head_details::updateOrCreate(
            [
                'id' => $requestData['id']
            ],
            $requestData
        );

        $status = array(
            'type' => 'success',
            'sid' => $result->id,
            'message' => 'Save Successfully'
        );
        header('Content-type: application/json');

        echo json_encode($status);
    }


    public function edit($id)
    {

        if (!Utility::permissionCheck('update-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        $data['currency'] = currency::get();
        $data['param'] = 1;
        $data['company_profile'] = company_profile::with(['account'])->findOrFail($id);
        $data['country'] = country::where('lang', 'en')->get();
        $data['industry'] = industry::where('lang', 'en')->get();
        $data['allTabActive'] = true;
        $data['languages'] = language::where('display_default', '1')->get();
        $data['status'] = Helper::getEnumValues('company_profiles','status');
        $data['compliance_groups'] = compliance_group::get();
        return view('/admin/.company_profile.edit', $data);
    }


    public function save_company_password(Request $request)
    {

        if (!Utility::permissionCheck('update-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }


        $this->validate($request, [
           // 'email' => 'required|string|email|max:255|unique:users'
            'email' => 'required|email|max:255|unique:users,email,' . $request->account_id,
        ]);


        $role_id = env('CLIENT_ROLE');

        if (!empty($request->password)) $password = bcrypt($request->password);
        $user = User::updateOrCreate(
            [
                'id' => $request->account_id,
            ],
            [
                'password' => $password,
                'name_title' => $request->name_title,
                'name' => $request->name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'user_type' => $role_id,
            ]);


        if ($user) {
            $requestData['login_account_id'] = $user->id;

            // return $company_profile = company_profile::findOrFail($request->id);
            company_profile::where('id', $request->id)->update($requestData);

            $user->assignRole($role_id);
            $status = array(
                'type' => 'success',
                'message' => 'Save Successfully'
            );
        }else{
            $status = array(
                'type' => 'failed',
                'message' => 'Duplicate User ID'
            );
        }
return 'success';

    }


    public function comm_attr($id)
    {

        if (!Utility::permissionCheck('update-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        $data['cid'] = $id;
        $data['company_profile'] = company_profile::with(['header'])->findOrFail($id);

        return view('/admin/.company_profile.comm_attr', $data);
    }


    public function update_attr(Request $request, $id)
    {

        if (!Utility::permissionCheck('update-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        $requestData = $request->all();
        if ($request->head)
            foreach ($request->head as $key => $value) {
                $division = company_head::updateOrCreate(
                    [
                        'id' => $value['id'],
                        'company_id' => $id,
                    ],
                    [
                        'head' => $value['name'],
                        'code' => $value['code']
                    ]
                );
            }


        ///company_department

        return redirect('company_options/' . $id)->with('flash_message', 'company_profile updated!');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {

        if (!Utility::permissionCheck('update-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }


        $this->validate($request, [
            'company_name' => 'required'
        ]);
        $requestData = $request->all();

    /*    if ($request->hasFile('file')) {
            $image = $request->file('file');
            // $name =    time() . '.' . $image->getClientOriginalExtension();
            $name    =  'logo_'.time().$image->getClientOriginalName();

            $path =    '/company_logo/';
            $destinationPath = public_path($path);
            $imagePath = $destinationPath .  $name;
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(200, 200);
            $image_resize->save($imagePath);

            //$image->move($destinationPath, $name);
            $requestData['company_logo'] = $path.$name;
            $requestData['base_url'] = asset('');
        }*/

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $name = time() . '_' . $image->getClientOriginalName();
            //$destinationPath = public_path('company_logo');
            $base_path = '/company_logo/';
             #$destinationPath =  public_path($base_path);
            #$imagePath = $destinationPath . "/" . $name;
            #$image->move($destinationPath, $name);
            $image->storeAs('company/company_logo/', $name ,'s3');

            $requestData['company_logo'] = $base_path.$name;
            $requestData['base_path'] = $base_path;
            $requestData['base_url'] = asset('');
        }


        $company_profile = company_profile::findOrFail($id);
        $company_profile->update($requestData);

        ///company_department

        return redirect('company_profile')->with('flash_message', 'company_profile updated!');
    }


    public function del_com_head(Request $request)
    {
        if (!Utility::permissionCheck('delete-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        company_head::destroy($request->id);

        $status = array(
            'type' => 'success',
            'message' => 'Successfully deleted'
        );
        header('Content-type: application/json');

        echo json_encode($status);
        //  return redirect('agent_jobs_candidate_todo_list')->with('flash_message', 'agent_jobs_candidate_todo_list deleted!');
    }


    public function del_com_division(Request $request)
    {
        if (!Utility::permissionCheck('delete-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        company_division::destroy($request->id);
        $status = array(
            'type' => 'success',
            'message' => 'Successfully deleted'
        );
        header('Content-type: application/json');

        echo json_encode($status);
        //  return redirect('agent_jobs_candidate_todo_list')->with('flash_message', 'agent_jobs_candidate_todo_list deleted!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return RedirectResponse|Redirector
     */
    public function destroy(Request $request, $id)
    {
        if (!Utility::permissionCheck('delete-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }



      //  company_profile::destroy($id);
        $udata['deleteitem'] = 1;
        company_profile::where('id', $id)->update($udata);

        return redirect('company_profile')->with('flash_message', 'company_profile deleted!');
    }

    public function destroy_options($id)
    {
        if (!Utility::permissionCheck('delete-company_profiles')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        company_head_details::destroy($id);

        $status = array(
            'type' => 'success',
            'message' => 'Successfully deleted'
        );
        header('Content-type: application/json');

        echo json_encode($status);
        //  return redirect('agent_jobs_candidate_todo_list')->with('flash_message', 'agent_jobs_candidate_todo_list deleted!');
    }

    ///////////////MHK Start/////////////////

    public function company_address(Request $request)
    {
        if ($request) {
            $data['address'] = company_address::with('CountryLoad', 'StateLoad', 'CityLoad')->where('company_id', $request->company_id)->get();
            return view('/admin/.company_profile.company_address', $data);
        }
    }

///////////////client complience///////////////

    public function company_compliance(Request $request)
    {
        if ($request) {
                $result = compliance_group_combination::with(['compliance','compliance_group','complianceFor'])
                  ->where('compliance_group_id', $request->default_compliance_group)
                  ->where('compliance_sector_code','client')->latest()->get();

             $data['compliances'] = $result->compliance;

            return view('/admin/.company_profile.company_compliance', $data);
        }
    }

    public function ComplianceForm(Request $request)
    {
        $data['company_id'] = $request->company_id;
        $data['result'] = compliance::with(['groups'])->where('id', $request->id)->where('user_id', Auth::id())->first();
        $data['compliance_group'] = compliance_group::latest()->get();
        $data['compliance_sectors'] =  compliance_sector::orderBy('title', 'ASC')->get();
        $data['type'] = compliance_type::all();
        return view('/admin/.company_profile.complianceForm', $data);
    }


    public function save_company_complience(Request $request)
    {
        if ($request) {
            $compliance_group_ids = @implode(',', $request->compliance_group_ids);
            $result = compliance::updateOrCreate(
                [
                    'id' => $request->complience_id,
                ],
                [
                    'compliance_sector_code' => $request->compliance_sector_code,
                    'title' => $request->title,
                    'type_id' => $request->type_id,
                    'compliance_group_ids' => $compliance_group_ids,
                    'desc' => $request->desc,
                    'user_id' => Auth::id()
                ]);

            compliance_group_combination::whereNotIn('complience_group_id', $request->compliance_group_ids)->where('compliance_id', $result->id)->delete();

            if(isset($request->compliance_group_ids))
                foreach($request->compliance_group_ids as $item){
                    compliance_group_combination::updateOrcreate([
                        'compliance_id' => $result->id,
                        'complience_group_id' => $item,
                    ]);
                }
            /*
            $info = company_compliance::updateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'company_id' => $request->company_id,
                    'compliance_id' => $result->id,
                ]);*/

            return $result;
        }
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////
    public function loadAddressForm(Request $request)
    {
        $data['company_id'] = $request->company_id;
        $data['address'] = company_address::where('company_id', $request->company_id)->where('id', $request->id)->first();
        $data['country'] = country::where('lang', 'en')->get();
        return view('/admin/.company_profile.address_form', $data);
    }

    public function save_company_address(Request $request)
    {
        if ($request) {

            if ($request->is_default == 1 && !empty($request->company_id)) {

                company_address::where('company_id', $request->company_id)->update(array('is_default' => 0));

            }

            $company_profile = company_profile::where('id',$request->company_id)->first();
            $result = company_address::updateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'company_id' => $request->company_id,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'address3' => $request->address3,
                    'address4' => $request->address4,
                    'address5' => $request->address5,
                    'city' => $request->city,
                    'state' => $request->state,
                    'postcode' => $request->postcode,
                    'country' => $request->country,
                    'is_default' => $request->is_default,
                    'address_type' => $request->address_type,
                ]);

            /////////////update company default Address/////
            if ($request->is_default == 1) {
                $company = company_profile::updateOrCreate([
                    'id' => $request->company_id,
                ],
                    [

                        'address1' => $request->address1,
                        'address2' => $request->address2,
                        'address3' => $request->address3,
                        'address4' => $request->address4,
                        'address5' => $request->address5,
                        'city' => $request->city,
                        'state' => $request->state,
                        'postcode' => $request->postcode,
                        'country' => $request->country
                    ]);





            }

            ////////////add master address book//////
            $addressdata = array(
                'user_id' => Auth::id(),
                'address_type' => 'company',
                'first_name' => '',
                'last_name' => '',
                'company' => $company_profile->company_name,
                'position' => '',
                'address1' => $request->address1,
                'address2' => $request->address2,
                'address3' => $request->address3,
                'address4' => $request->address4,
                'address5' => $request->address5,
                'city' => $request->city,
                'state' => $request->state,
                'post_code' => $request->postcode,
                'country' => $request->country,
                'phone_number' => '',
                'mobile' =>$company_profile->company_phone,
                'email' => $company_profile->company_email,
                'website' => $company_profile->website
            );
            app('App\Http\Controllers\address_bookController')->addAddress($addressdata);

            return $result;
        }
    }

    ////////////////////////////////////////////////////////////////////////////////

    public function delete_comAddress($id, Request $request)
    {
        $companyAddressDel = company_address::where('id', $id)->where('company_id', $request->company_id)->first();
        $companyAddressDel->delete();

    }


/////////////////////////////////////Company Contact Info////////////////////////////////////////////////////
    public function company_contacts(Request $request)
    {
        if ($request) {
             $data['contact_info'] = company_contact_info::with(['emails','phones'=>function($q){
                $q ->select(DB::raw('company_contact_info_id, CONCAT(phone_code, phone) as phone_number'));
            }])->where('company_id', $request->company_id)->get();
            return view('/admin/.company_profile.company_contact_info', $data);
        }
    }

    public function company_todolist(Request $request)
    {
        $data['result'] = agent_jobs_candidate_todo_list::where('type','Client')->where('foreigen_id', $request->company_id)->latest()->get();
        return view('/admin/.company_profile.todo_data', $data);
    }

    public function addEditTodoForm(Request $request)
    {
          $data['company_id'] = $request->company_id;
        $data['todo'] = agent_jobs_candidate_todo_list::where('id', $request->id)->first();
        $data['enumstatus'] = Helper::getEnumValues('agent_jobs_candidate_todo_lists', 'status');
        $data['enumtypes'] = Helper::getEnumValues('agent_jobs_candidate_todo_lists', 'type');
        $data['contacts']  = company_contact_info::select('id','contact_name' )->where('company_id',$request->company_id)->orderBy('contact_name','ASC')->get();
        $data['treeuser'] = app('App\Http\Controllers\workflow_template_settingController')->getTreeUser(); //User::where('parent_user_id', Auth::id() )->get();

        return view('/admin/.company_profile.addEditTodoForm', $data);
    }


    public function save_company_todo(Request $request)
    {
        $date = Carbon::createFromFormat('d/m/Y H:i', $request->date)->format('Y-m-d H:i');
       $result=  agent_jobs_candidate_todo_list::UpdateOrCreate([
            'id' => $request->id
        ],[
                'agent_id' => Auth::id(),
                'type' => $request->type,
                'foreigen_id'=> $request->foreigen_id,
                'title' => $request->title,
                'note'=>$request->note,
                'date'=> $date,
                'contact_person'=> $request->contact_person,
                'status'=>$request->status,
                'assign_person'=>@implode(',',$request->assign_person)
            ]
        );



        if(!empty($request->followupdate)){
            $date = Carbon::createFromFormat('d/m/Y H:i', $request->followupdate)->format('Y-m-d H:i');

            agent_jobs_candidate_todo_list::Create([
                    'ref_id'=> $result->id,
                    'agent_id' => $result->agent_id,
                    'type' => $request->type,
                    'foreigen_id'=> $request->foreigen_id,
                    'title' => $request->title,
                    'note'=>$request->note,
                    'date'=> $date,
                    'contact_person'=> $request->contact_person,
                    'status'=>$request->status,
                    'assign_person'=>@implode(',',$request->assign_person)
                ]
            );
        }

        return 1;
    }


    public function deleteClientTodo(Request $request)
    {
        agent_jobs_candidate_todo_list::where('id', $request->id)->delete();
        return "Successfully Deleted";
    }

    public function loadContactForm(Request $request)
    {
        $data['company_id'] = $request->company_id;
        $data['contacts'] = company_contact_info::with(['emails','phones'=>function($q){
            $q ->select(DB::raw('*,CONCAT(phone_code, phone) as phone_number'));
        }])->where('company_id', $request->company_id)->where('id', $request->id)->first();

         $data['addresses'] = company_address::select(DB::raw('*, CONCAT_WS(", ", address1,address2,address3,address4,address5,city,state,postcode,country) AS address'))->where('company_id', $request->company_id)->get();
        $data['name_titles'] = name_title::all();

        return view('/admin/.company_profile.contact_person_form', $data);
    }



    public function save_contact_person(Request $request)
    {
        if ($request) {

            if ($request->is_default == 1 && !empty($request->company_id)) {
                company_contact_info::where('company_id', $request->company_id)->update(array('is_default' => 0));
            }

            $requestData = $request->all();
            if ($request->hasFile('business_card')) {
                  $image = $request->file('business_card');
                $name = time() . '.' . $image->getClientOriginalExtension();

                $img_dir = 'business_card/';
                $image->storeAs('business_card/', $name ,'s3');
                // Create folders if they don't exist
                /*if (!file_exists($img_dir)) {
                    mkdir(public_path($img_dir), 0777, true);
                }*/
                //$image->move(public_path($img_dir), $name);
                 $requestData['business_card'] = $img_dir . $name;
            }

            $company_profile = company_profile::where('id',$request->company_id)->first();
            $requestData['contact_name'] = $request->name_title.' '.$request->first_name.' '.$request->middle_name.' '.$request->last_name;

            $result = company_contact_info::updateOrCreate(
                [
                    'id' => $request->id,
                ],
                $requestData
            );

            $emails = '';

            if (isset($request->head)) {
                foreach ($request->head as $key => $item) {
                    company_contact_email::updateOrCreate(
                        [
                            'id' => $item['id'],
                        ],
                        [
                            'company_contact_id' => $result->id,
                            'email' => $item['email'],
                            'default' => ($request['email_default'] == $key) ? 1 : 0,
                        ]);
                    $emailArr[] = $item['email'];
                }
               $emails  = @implode(',',$emailArr);
            }


            if (isset($request->phone)) {
                foreach ($request->phone as $key => $item) {
                    $cc = company_contact_info_phone::updateOrCreate(
                        [
                            'id' => $item['id'],
                        ],
                        [
                            'company_contact_info_id' => $result->id,
                            'phone_code' => $item['phone_code'],
                            'phone' => $item['phone'],
                            'type' => $item['type'],
                            'is_default' =>($request['phone_default'] == $key) ? 1 : 0,
                        ]);

                    $phoneArr[] =  $item['phone_code'].$item['phone'];
                }
               // $phones  = @implode(',',$phoneArr);

            }

           // if(!empty($request->contact_phone1))  $phoneArr[] = $request->contact_phone1;
          // if(!empty($request->contact_phone2))  $phoneArr[] = $request->contact_phone2;
            $phones = @implode(',',$phoneArr);
            ////////////add master address book//////
            $addressdata = array(
                'user_id' => Auth::id(),
                'address_type' => 'contact',
                'first_name' => $request->contact_name,
                'last_name' => '',
                'company' =>  '',
                'position' => $request->contact_designation,
                'address1' => '',
                'address2' => '',
                'address3' => '',
                'address4' =>'',
                'address5' => '',
                'city' =>'',
                'state' => '',
                'post_code' => '',
                'country' => '',
                'phone_number' =>  '',
                'mobile' => $phones,
                'email' => $emails,
                'website' => ''
            );
            app('App\Http\Controllers\address_bookController')->addAddress($addressdata);

            // return $result;
        }
    }

    public function delete_comContact($id, Request $request)
    {
        $companyContactDel = company_contact_info::where('id', $id)->where('company_id', $request->company_id)->delete();

    }


    public function del_contact_person_phone(Request $request)
    {
        company_contact_info_phone::where('id', $request->id)->delete();
    }

    public function delete_company_complience($id, Request $request)
    {
        $companyComplienceDel = compliance::where('id', $id)->where('user_id', Auth::id())->first();
        $companyComplienceDel->delete();
    }

    public function del_com_person_email(Request $request)
    {
        $companyEmailDel = company_contact_info::where('id', $request->id)->first();
        $companyEmailDel->delete();
    }




    public function delete_company_profile(Request $request)
    {

        if(isset($request->ids))
            foreach ($request->ids as $id) {

                   $udata['deleteitem'] = 1;
                   company_profile::where('id', $id)->update($udata);
               /* $companyEmailDel = company_profile::where('id', $id)->delete();
                company_address::where('company_id',$id)->delete();
                company_contact_info::where('company_id', $id)->delete();*/
            }
        return "Successfully Deleted";
    }


}
