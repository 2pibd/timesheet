<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Utility\Utility;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if(!Utility::permissionCheck('view-permission'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

          $permissions = Permission::all()->sortByDesc("created_at");

        return view('admin.permission.index', compact('permissions'));
    }



    public function create()
    {
        if(!Utility::permissionCheck('create-permission'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }
        return view('admin.permission.create');
    }



    public function store(Request $request)
    {
        if(!Utility::permissionCheck('create-permission'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        $this->validate($request, [
           // 'title' => 'required',
            'name' => 'required|unique:permissions'
        ]);
        $requestData = $request->all();

        // make "User Can Read" to "user_can_read" for permission name

        $permissionName =  snake_case($request->name, '-'); // "SnakeCase" -> snake-case

        $requestData['name'] = $permissionName;

        Permission::create($requestData);

        // give this permission to super admin when create a permission
        $role = Role::findByName('super-admin');
        $role->syncPermissions(Permission::all());
        return redirect('admin/permission')->with('success', 'Permission added!');
    }



    public function show(Permission $permission)
    {
        if(!Utility::permissionCheck('view-permission'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        return view('admin.permission.show', compact('permission'));
    }



    public function edit(Permission $permission)
    {
        if(!Utility::permissionCheck('update-permission'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }
        return view('admin.permission.edit', compact('permission'));
    }



    public function update(Request $request, Permission $permission)
    {

        if(!Utility::permissionCheck('update-permission'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }


        $this->validate($request, [
          //  'title' => 'required',
            'name' => 'required'
        ]);
        $requestData = $request->all();

        $permission->update($requestData);

        return redirect('admin/permission')->with('success', 'Permission updated!');
    }



    public function destroy(Permission $permission)
    {
        if(!Utility::permissionCheck('delete-permission'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        try {
            $permission->delete();

        } catch (\Exception $e) {

            return redirect('permission')->with('error', "Error In Permission Revoking and Deletion");

        }


        return redirect('admin/permission')->with('success', 'Permission deleted!');
    }
}
