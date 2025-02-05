<?php
namespace App\Http\Controllers;
use App\Helpers\Helper;
use App\Http\Requests;
use App\Models\User;
use App\Models\User_address;
use Session;
use Carbon\CarbonInterval;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;

use App\Utility\Utility;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;


use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Hash;
use DB;
use Facades\App\Repository\user_info;
use Carbon\Carbon;
use App\Http\Controllers\Redirect;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!Utility::permissionCheck('view-user')) {
            return back()->with('error', Utility::getPermissionMsg());
        }
        $keyword = $request->get('search');
        $perPage = 10;
        $query = User::latest();
        if (!empty($keyword)) {
            $query = $query->where('id', 'LIKE', "%$keyword%")
                ->orWhere('mobile', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%");
        }

        $status = $request->get('status');
        if(!empty($searchByusertype)){
            $query=$query->where('status', $status);
        }
        $searchByusertype = $request->get('searchByusertype');
        if(!empty($searchByusertype)){
            $query=$query->whereHas(
                'roles', function ($q) use($searchByusertype) {
                $q->where('name', $searchByusertype);
            });
        }

        //$users = $query->paginate($perPage);
     //   $data['roles'] =['super-admin', 'admin', 'Accounts', 'Manager', 'Pathologist','Pharmacist','Receptionist','Nurse','Doctor','Pharmaceutical Company'];
          $data['roles'] =Role::all()->pluck('name');

    $data['users'] = $query->whereHas(
            'roles', function ($q) use ($data) {
            $q->whereIn('name',  $data['roles']);
        })->paginate($perPage);


           $data['status'] = Helper::getEnumValues('users', 'status');
        return view('admin.user.index', $data);
    }

    public function resetByphone(Request $request)
    {
        $chekUser = User::where('phone', $request->phone)->where('account_id', $request->account_id)->first();
        if ($chekUser) {
            $password = random_int(100000, 999999);
            $requestData['password'] = bcrypt($password); //bcrypt($request->password);
            $user = $chekUser->update($requestData);

            if (!empty($request->phone)) {
                $smsArr['mob_number'] = $request->phone;
                $smsArr['message'] = "আপনার নতুন Password টি হলো " . $password . "
উপরোক্ত তথ্য ব্যবহার করে লগ ইন করুন - Site name";

                Helper::sendSMS($smsArr);
            }

            return redirect()->route('login');
        } else  return redirect()->back()->with('status', 'Invalid account number or phone number');
    }

    public function profile()
    {
        $data['user'] = $user = Auth::user();
        $data['role'] = $user->roles()->first();

        $now = Carbon::now();
        $currentMonth = date('m');
        $currentDate = date('Y-m-d');

        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

             $todaylogged = DB::table('login_logs')
            ->select(DB::raw("SUM(TIME_TO_SEC(TIMEDIFF(logout_time, login_time))) AS timelog, created_at"))
            ->where('user_id', $user->id)
            ->whereDate('created_at', $currentDate)
            ->get();



        $todaylogged = (isset($todaylogged)) ? $todaylogged[0]->timelog : '';
        $dt = Carbon::now();
        //   $days = $dt->diffInDays($dt->copy()->addSeconds($todaylogged));
        $hours = $dt->diffInHours($dt->copy()->addSeconds($todaylogged));
        $minutes = $dt->diffInMinutes($dt->copy()->addSeconds($todaylogged)->subHours($hours));
    $data['todaylogged'] = CarbonInterval::hours($hours)->minutes($minutes)->forHumans();



         $weeklylogged = DB::table('login_logs')
            ->select(DB::raw("SUM(TIME_TO_SEC(TIMEDIFF(logout_time, login_time))) AS timelog, created_at"))
            ->where('user_id', $user->id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$weekStartDate, $weekEndDate])
            ->groupBy('created_at')
            ->get();

        $weeklylogged = isset($weeklylogged[0]) ?$weeklylogged[0]->timelog:'N/A';

        $dt = Carbon::now();
        //  $days = $dt->diffInDays($dt->copy()->addSeconds($weeklylogged));
        $hours = $dt->diffInHours($dt->copy()->addSeconds($weeklylogged));
        $minutes = $dt->diffInMinutes($dt->copy()->addSeconds($weeklylogged)->subHours($hours));
        $data['weeklylogged'] = CarbonInterval::hours($hours)->minutes($minutes)->forHumans();

   $monthlylogged = DB::table('login_logs')
            ->select(DB::raw("SUM(TIME_TO_SEC(TIMEDIFF(logout_time, login_time))) AS timelog, created_at"))
            ->where('user_id', $user->id)
            ->whereMonth('created_at', $currentMonth)
            ->groupBy('created_at')
            ->get();


        $monthlylogged = isset($monthlylogged[0]) ?$monthlylogged[0]->timelog:'N/A';
        $dt = Carbon::now();
        //   $days = $dt->diffInDays($dt->copy()->addSeconds($monthlylogged));
        $hours = $dt->diffInHours($dt->copy()->addSeconds($monthlylogged));
        $minutes = $dt->diffInMinutes($dt->copy()->addSeconds($monthlylogged)->subHours($hours));
     $data['monthlylogged'] = CarbonInterval::hours($hours)->minutes($minutes)->forHumans();

        return view('admin.user.userProfile', $data);
    }

    public function upload_profile_picture(Request $request)
    {
        $user = Auth::user();
        $image = $request->file('file');

        $name = $user->id . '_profile.' . $image->getClientOriginalExtension();
        $path = 'profileImage/';
        $destinationPath = public_path($path);
        $imagePath = $destinationPath . $name;
        $image->move($destinationPath, $name);
        $requestData['photo'] = $path . $name;

        if ($user) {
            $user->update($requestData);
        }
    }


    public function getUserList(Request $request)
    {

        $query = User::latest();

        if(isset($request->usertype)) {
            $usertype = $request->usertype;
            $query = $query->whereHas(
                'roles', function ($q) use ($usertype) {
                $q->where('name', $usertype);
            });
        }

        if(!empty($request->fromdate)){
            $fromDate = Carbon::createFromFormat('d/m/Y', $request->fromdate)->format('Y-m-d') ;
            $query = $query->where('created_at','>=', $fromDate);
        }

        if(!empty($request->todate)){
            $toDate = Carbon::createFromFormat('d/m/Y', $request->todate)->format('Y-m-d') ;
            $query = $query->where('created_at','<=', $toDate);
        }


          $data = $query->get();

        return datatables()->of($data)
            ->addColumn('name', function ($data) {
                $name = $data->name ;
                return $name;
            })
            ->addColumn('email', function ($data) {
                return $data->email;
            })
            ->addColumn('phone', function ($data) {
                return $data->phone;
            })

            ->addColumn('roll', function ($data) {
                $roll = $data->getRoleNames()->first() ;
                return $roll;
            })
            ->addColumn('status', function ($data) {
                return $data->status;
            })
       /*     ->addColumn('status', function ($data) {
                if( $data->status == 1) $status = 'Active'; else  $status = 'Inactive';
                return $status ;
            })*/
            ->addColumn('created_at', function ($data) {
                return $data->created_at;
            })
            ->addColumn('action', function ($data) {
                $button = '<ul class="list-inline hstack gap-2 mb-0"> <li class="list-inline-item">
                                                    <div class="dropdown">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="ri-more-fill align-middle"></i>
                                                        </button> <ul class="dropdown-menu dropdown-menu-end">';
                if (Utility::permissionCheck('view-user')) {
                    $button .= ' <li><a href="' . route('user.show', $data->id) . '" class="dropdown-item view-item-btn"
               title="View"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>';
                }

                if (Utility::permissionCheck('update-user')) {
                    $button .= ' <li><a href="' . route('user.edit', $data->id) . '" class="dropdown-item edit-item-btn"
               title="Edit"> <i  class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                </a></li>';
                }


                if (Utility::permissionCheck('delete-user')) {
                    $button .= '<li><form method="POST"
                  action="' . route('user.destroy', $data->id) . '"   accept-charset="UTF-8" style="display:inline">
                ' . method_field('DELETE') . csrf_field()
                        . '<button type="submit" class="dropdown-item  btn-link text-black btn-xs"
                        title="Delete"
                        onclick="return confirm(&quot;Confirm delete?&quot;)">
                        <i  class="ri-delete-bin-fill align-bottom me-2"></i> Delete</button>
            </form></li>';
                }
                $button.='  </ul>  </div>  </li>';
                return $button;
            })
            ->rawColumns(['action','name'])
            ->make(true);

    }


    public function loadSignatureForm(Request $request)
    {
        $data['user'] = Auth::user();
        return view('admin.user.loadSignatureForm', $data);
    }

    public function userSignatureUpdate(Request $request)
    {
        if (!empty($request->uid)) {
            $user = user::where('id', $request->uid)->first();
        } else $user = Auth::user();

        $requestData = $request->all();
        if ($user) {
            $user->update($requestData);
            return ([
                'status' => 'success',
                'message' => "Successfully updated"
            ]);
        }
    }


    public function loadEditProfileForm(Request $request)
    {
        if (empty($request->step)) $data['user'] = Auth::user();
        $data['roles'] = Role::all();
        $data['role_type'] = Auth::user()->roles()->first()->name;
        return view('admin.user.userProfile_edit', $data);
    }

    public function changePasswardForm(Request $request)
    {
        $data['user'] = Auth::user();
        return view('admin.user.changePasswardForm', $data);
    }

    public function updatePassword(Request $request)
    {
        if ($request->new_password != $request->confirmpass)
            $message = json_encode(['message' => 'Confirm Password does not match', 'status' => 'failed']);

        $user = Auth::user();
        $this->validate($request, [
            'password' => 'required',
            'password' => 'confirmed|max:6|different:password',
        ]);

        if (Hash::check($request->oldpassword, $user->password)) {
            $user->fill(['password' => Hash::make($request->new_password)
            ])->save();
            return $message = json_encode(['message' => 'Successfully Password updated', 'status' => 'success']);

        } else {
            return $message = json_encode(['message' => 'Old Password does not match', 'status' => 'failed']);
        }
    }


    public function userProfileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            //  'email' => 'required|email|max:255|unique:users',
            //'account_id' => 'required|string|unique:users',
            // 'role_id' => 'required'
        ]);

         $user = User::where('id', $request->uid)->first();

        $requestData = $request->all();
        $requestData['account_id'] = $request->email;
        if ($user) {
            $user->update($requestData);
        } else {
            if(Auth::user()->roles()->first()->name == 'Doctor')
                $requestData['ref_id'] = Auth::id();
            $requestData['user_type'] = $request->role_type;

            $user = User::create($requestData);
        }
        if (isset($request->role_id)) {
            if (Utility::permissionCheck('create-user')) {
                $role = $request->role_id;
                $user->syncRoles($role);
            }
        } else if (isset($request->role_type)) {
            $user->assignRole($request->role_type);
        }
        $user = User::where('id', $user->id)->first();
        return $user;
    }

    public function create()
    {
        if (!Utility::permissionCheck('create-user')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        $data['genders'] = Helper::getEnumValues('users', 'gender');
        // $memberships = Membership::all();
        $data['roles'] = Role::all();
        $data['status'] = Helper::getEnumValues('users', 'status');

        return view('admin.user.create', $data);
    }


    public function veryfied($id)
    {
        $user = User::findOrFail($id);
        if (($user->verified === null)) {
            $updateRequest['verified'] = 1;
            $user = DB::table('users')
                ->where('id', $id)
                ->update($updateRequest);
        } else {
            $updateRequest['verified'] = null;
            $user = DB::table('users')
                ->where('id', $id)
                ->update($updateRequest);
        }

        //return redirect()->route('index', ['id' => 1]);
        return redirect()->route('admin.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */


    public function store(Request $request)
    {
        if (!Utility::permissionCheck('create-user')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|max:255|unique:users',
            // 'account_id' => 'required|string|unique:users',
            'role_id' => 'required'
        ]);

        $requestData = $request->except('role_id');
        $requestData['user_type'] = $request->role_id[0];
        $requestData['password'] = bcrypt($request->password);

        $role = $request->role_id;
        //   $requestData['user_type'] = $role;

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('profileImage');
            $imagePath = $destinationPath . "/" . $name;
            $image->move($destinationPath, $name);
            $requestData['photo'] = $name;
        }

        $user = User::create($requestData);
        $user->syncRoles($role);

        if(!empty($request->address)){
            user_address::updateOrCreate([
                'user_id'=> $user->id,
                'address_type'=> 'Permanent'
            ],[
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
        }

         session()->flash('message', 'Created Successfully');

        return redirect('admin/user')->with('success', 'User Successfully added!');

    }


    public function show(User $user)
    {
        if (!Utility::permissionCheck('view-user')) {
            return back()->with('error', Utility::getPermissionMsg());
        }
        return view('admin.user.show', compact('user'));
    }


    public function edit(User $user)
    {
        if (!Utility::permissionCheck('update-user')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        $data['user'] = $user;
         $data['genders'] = Helper::getEnumValues('users', 'gender');
        $data['roles'] = Role::all();
        $data['status'] = Helper::getEnumValues('users', 'status');


        return view('admin.user.edit', $data);
    }


    public function update(Request $request, User $user)
    {
        if (!Utility::permissionCheck('update-user')) {
            return back()->with('error', Utility::getPermissionMsg());
        }


        $this->validate($request, [
            'first_name' => 'required',
            //  'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            // 'account_id' => 'required|string|unique:users,account_id,'.$user->id,
            'role_id' => 'required'
        ]);

     $userId = $user->id; // Auth::id();
        $user = User::findOrFail($userId);
        $userName = str_replace(" ", "", $user->name);

        if ($request->hasFile('file')) {
            # $imageName = request()->file->getClientOriginalName();
            #request()->file->move(public_path('upload'), $imageName);
            #return response()->json(['uploaded' => '/upload/'.$imageName]);

            if (!empty($user->photo)) $path = public_path('profileImage') . $user->photo; else $path = public_path('profileImage');

            if (File::exists($path)) {
                File::delete($path);
                $image = $request->file('file');
                $name = $userId . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('profileImage');
                $imagePath = $destinationPath . "/" . $name;
                $image->move($destinationPath, $name);
                $requestData['photo'] = $name;
            } else {

                $image = $request->file('file');
                $name = $userId . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('profileImage');
                $imagePath = $destinationPath . "/" . $name;
                $image->move($destinationPath, $name);
                $requestData['photo'] = $name;

            }
        }


        $request->password;
        $requestData = $request->except('role_id');
        $requestData['password'] = (!empty($request->password)) ? bcrypt($request->password) : $user->password;

        #$requestData['user_type'] =  $request->role_id;
        $requestData['name'] =$request->name_title.' '.$request->first_name.' '.$request->middle_name.' '.$request->last_name;
            //return $requestData;
        $user->update($requestData);
        //$role = $request->role_id;
        $role = Role::find( $request->role_id);
             $user->syncRoles($role);

        if(!empty($request->address)){
            user_address::updateOrCreate([
                'user_id'=> $user->id,
                'address_type'=> 'Permanent'
            ],[
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
        }




        $message = 'User With Role Updated';

        session()->flash('message', 'Created Successfully');
        return redirect('admin/user')->with('success', isset($message) ? $message : 'User updated! Only Super Admin Can Change Assigned Role');
    }


    public function destroy(User $user)
    {
        if (!Utility::permissionCheck('create-user')) {
            return back()->with('error', Utility::getPermissionMsg());
        }


        $allRoles = $user->getRoleNames();

        foreach ($allRoles as $role) { //remove all role of user before delete this user.
            $user->removeRole($role);
        }

        $ifDelete = $user->delete();
        return redirect('user')->with('success', 'User  deleted Successfully!');

    }

    public function profile_access($remember_token)
    {
        $user =Auth::user();
        $role = $user->roles()->first()->name;
        if( @in_array($role, ['admin','SuperAdmin']) ){
            // set data
            $token = sha1($user->id.time());
            $user->update(['remember_token'=>$token] );
            $data = [
                "auth_token" =>$remember_token,
                "back_token" =>  $token,
            ];
// storing $data to session
            session($data);
        }else{
            Session::flush();
        }


        $user =  User::where('remember_token', $remember_token)->first();
        if($user)  Auth::login($user);

        //  Auth::loginUsingId($uid);

        // return Auth::user();
        return redirect('admin');
    }

    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function ajaxTreeUserJSON()
    {
        return $treeuser = app('App\Http\Controllers\workflow_template_settingController')->getTreeUser(); //User::where('parent_user_id', Auth::id() )->get();

    }
}



