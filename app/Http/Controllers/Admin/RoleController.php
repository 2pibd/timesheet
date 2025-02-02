<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User_role_group;

use App\Utility\Utility;
use App\Models\Menu;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use DB;
class RoleController extends Controller
{

    public function index(Request $request)
    {
        if(!Utility::permissionCheck('view-role'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }
        $roles = Role::with('user_role_group')->orderBy('user_role_group_id','ASC') ;

        if($request->searchkey) $roles =  $roles->where('name','LIKE','%'.$request->searchkey.'%');

        if($request->user_role_group_id) $roles =   $roles->where('user_role_group_id',  $request->user_role_group_id);


        $data['roles'] = $roles->get();

        $data['user_role_group'] =  User_role_group::all();
        return view('admin.role.index', $data);
    }


    public function create()
    {
        if(!Utility::permissionCheck('create-role'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        ///////////////readinto file json//////////////////////

        $rolePermissions = array();

        $rolePermissionsLevels =  $permissions = Permission::all();
        foreach($rolePermissionsLevels as $key=>$item)
            $AllPermission[$item->name]=$item->title;


        $menus = Menu::where('status', 1)->orderBy('order_by', 'ASC')->get();
        foreach ($menus as $key => $value) {
            $chkmenu = array();
            $actionArr = explode(',', $value->permission_class);
            $array[$value['id']] = array(
                "parent_id" => $value['parent_id'],
                "permission_class" =>   $actionArr,
                "title" =>  $value->title,
                "route" =>  $value->route,
                "icon" =>  $value->icon,
                "chkmenu" =>  $chkmenu,
                "status" => $value->status,
            );
        }
        $dataArr['menus'] = $array;
        $dataArr['rolePermissions'] = $rolePermissions;
        $dataArr['AllPermission'] = $AllPermission;

        $dataArr['user_role_group'] =  User_role_group::all();
        return view('admin.role.create', $dataArr);
        //return view('admin.role.create')->with('permissions', $permissionData)->with('menus',$menus);

        // return view('admin.role.create')->with('permissions', $permissionData);
    }
    public function update_sortaccess(Request $request)
    {

        if (!Utility::permissionCheck('update-role')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        Role::where('id',$request->id)->update(['sort_access_no' => $request->sortid]);

        echo 'Updated Successfully';

    }





    public function getPermissionPrefix($permissionName){


        if(strpos($permissionName,'create-') === 0){

            return 'Create';

        }else if(strpos($permissionName,'view-') === 0){

            return 'View';

        }else if(strpos($permissionName,'update-') === 0){


            return 'Update';

        }else if(strpos($permissionName,'delete-') === 0){


            return 'Delete';

        }else if(strpos($permissionName,'self-') === 0){


            return 'Self';
        }else{

            return null;
        }

    }


    public function getModuleFromPermission($permissionName){


        if(strpos($permissionName,'create-') === 0){

            return str_replace('create-','', $permissionName);

        }else if(strpos($permissionName,'view-') === 0){

            return str_replace('view-','', $permissionName);

        }else if(strpos($permissionName,'update-') === 0){
            return str_replace('update-','', $permissionName);

        }else if(strpos($permissionName,'delete-') === 0){
            return str_replace('delete-','', $permissionName);

        }else if(strpos($permissionName,'self-') === 0){
            return str_replace('self-','', $permissionName);
        }else{

            return null;
        }

    }

    public function store(Request $request)
    {
        if(!Utility::permissionCheck('create-role'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }


        $this->validate($request, [
            'name' => 'required|unique:roles',
            'permissions' => 'required'
        ]);

        $permissions = $request->permissions;

        $role = Role::create(['name' => $request->name, 'user_role_group_id'=>$request->user_role_group_id, 'sort_access_no'=>$request->sort_access_no]);

        $role->givePermissionTo($permissions);



        $file = public_path('menus/json_file/').$role->id.'.json';
        $handle = @fopen($file, 'w'); // Open the file for writing

        if ($handle) {
            @fwrite($handle, '{"menuArr":'.json_encode($request->menus_id).'}'); // Write to the file
            @fclose($handle); // Close the file
        }


        session()->flash('message', 'Created Successfully');

        return redirect('admin/role')->with('success', 'Role Successfully added!');
    }


    public function show(Role $role)
    {
        if(!Utility::permissionCheck('view-role'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }


        return view('admin.role.show', compact('role'));
    }



    public function edit(Role $role)
    {



        if(!Utility::permissionCheck('update-role'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        ///////////////readinto file json//////////////////////
        $file = public_path('menus/json_file/') . $role->id . '.json';
        $data = file_get_contents($file);
        $dataArr = json_decode($data, true);
        $menuJson = $dataArr['menuArr'];
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $rolePermissionsLevels = Permission::select('name','title')->get();

        foreach($rolePermissionsLevels as $key=>$item)
            $AllPermission[$item->name]=$item->title;

        /////////////////////////////////////
        $permissions = Permission::all();

        //$menus = Menu::all()->where('status', 1)->orderBy('order_by','ASC');
        $menus = Menu::where('status', 1)->orderBy('order_by', 'ASC')->get();
        foreach ($menus as $key => $value) {
            $chkmenu = (!empty($menuJson[$value->parent_id])) ? $menuJson[$value->parent_id] : $menuJson;
            $actionArr = explode(',', $value->permission_class);


            $array[$value['id']] = array(
                "parent_id" => $value['parent_id'],
                "permission_class" =>   $actionArr,
                "title" =>  $value->title,
                "route" =>  $value->route,
                "icon" =>  $value->icon,
                "chkmenu" =>  $chkmenu,
                "status" => $value->status,
            );
        }
        $dataArr['menus'] = $array;
        $dataArr['role'] = $role;
        $dataArr['rolePermissions'] = $rolePermissions;
        $dataArr['AllPermission'] = $AllPermission;
        $dataArr['user_role_group'] =  User_role_group::all();
        return view('admin.role.edit', $dataArr);

    }


    public function update(Request $request, Role $role)
    {
        if(!Utility::permissionCheck('update-role'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }



        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required'
        ]);



         $file = public_path('menus/json_file/').$role->id.'.json';
        $handle = @fopen($file, 'w'); // Open the file for writing

        if ($handle) {
            @fwrite($handle, '{"menuArr":'.json_encode($request->menus_id).'}'); // Write to the file
            @fclose($handle); // Close the file
        }


        if($role->name == 'SuperAdmin' || $role->name == 'admin' ){
            $message = 'Role With Permission updated! But Super-Admin and Admin role name will not change';
        }else{
            $role->update(['name' => $request->name, 'user_role_group_id' =>$request->user_role_group_id, 'sort_access_no' =>$request->sort_access_no]);
         $message = ucfirst($role->name).' Role With Permission updated!';
        }

        if($role->name == 'SuperAdminX'){
                $role->syncPermissions(Permission::all());
            $message .= ". Also Super Admin always get the full previlage";
        }else{
            $role->syncPermissions($request->permissions);
        }



        session()->flash('message', 'Updated Successfully');

        return redirect()->route('role.edit', $role->id)->with('success', $message);
    }



    public function destroy(Role $role)
    {
        if(!Utility::permissionCheck('delete-role'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        if($role->name == 'super-admin'){

            return redirect('role')->with('error', "Sorry ! Super Admin Role Cant be Deleted");

        }else{

            $role->revokePermissionTo(Permission::all());

            try {
                $role->delete();

            } catch (\Exception $e) {

                return redirect('role')->with('error', "Error In Roll Deletation and Permission Revoking");

            }

            return redirect('role')->with('success', "Roll Deleted Successfully and Permission Revoked");
        }

    }
}
