<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Menu;
use Spatie\Permission\Models\Permission;
use App\Utility\Utility;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

use Auth;
class menuController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }


    public function index(Request $request)
    {
          if(!Utility::permissionCheck('view-menu'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

		  $status = Helper::statusList();
		 #print_r( $p);
		 $pageLimit = Helper::configList();

        #$menus = menu::all();
        if($request->userType){
            $file = public_path('menus/json_file/').$request->userType.'.json';
            $data = file_get_contents($file);
            $dataArr = json_decode($data,true);
            $menuJson =   $dataArr['menuArr'];

            $menus =    menu::where('title','LIKE','%'.$request->searchkey.'%')->paginate($pageLimit['page_limit']);
        }else
         if($request->searchkey){
             $menus =  menu::where('title','LIKE','%'.$request->searchkey.'%')->paginate($pageLimit['page_limit']);
         }else   $menus = menu::orderBy("order_by",'ASC')->paginate($pageLimit['page_limit']);

        $allMenus = menu::all();
        $roles = Role::all();

		 $parentCatArr = array();
		 foreach($allMenus  as $key=>$value){
			 $parentCatArr[$value['id']] = $value['title'];
			 }

		  return view('admin.menu.index',  ['menus' => $menus,'roles' => $roles,  'status'=>$status, 'parentCatArr'=>$parentCatArr] );

    }


    public function create()
    {
        if(!Utility::permissionCheck('create-menu'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

           $status = Helper::statusList();

		    $menus = menu::all();

		   //$permissions =  permission::pluck('name')->toArray();
           $permissions =  permission::all('name');

		  return view('admin.menu.create', ['menus' => $menus, 'status'=>$status, 'permissions'=>$permissions] );
        // return view('/pages/.menu.create');
    }


    public function store(Request $request)
    {
        if(!Utility::permissionCheck('create-menu'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        $this->validate($request, [
			'title' => 'required'
		]);

        $requestData = $request->all();

        $requestData['left'] = ($request->left == 1)? 1 : 0;
        $requestData['top'] = ($request->top == 1)? 1 : 0;
        $requestData['footer'] = ($request->footer == 1)? 1 : 0;

          $requestData['permission_class'] = (!empty($requestData['permission_class']))?implode(',',$requestData['permission_class'] ):'';

        menu::create($requestData);

		 ///////////////////////////////////////////////////////////////
		// $menus = menu::all('id','title','parent_id','route','permission_class','icon','options','status')->where('status', 1);
        $menus = menu::select('id','title','parent_id','route','permission_class','admin_left_section','icon','options','status')->where('status', 1)->where('left', 1)->get();
		 $newMenu = array();
		 foreach($menus as $key=>$value){
			 $newMenu[$value['id']]['title'] = $value['title'];
			 $newMenu[$value['id']]['parent_id'] = $value['parent_id'];
			 $newMenu[$value['id']]['route'] = $value['route'];
			 $newMenu[$value['id']]['icon'] = $value['icon'];
             $newMenu[$value['id']]['admin_left_section'] = $value['admin_left_section'];
			 $newMenu[$value['id']]['permission_class'] = $value['permission_class'];
			 $newMenu[$value['id']]['icon'] = $value['icon'];
			 $newMenu[$value['id']]['options'] = $value['options'];
             $newMenu[$value['id']]['top'] = $value['top'];
             $newMenu[$value['id']]['left'] = $value['left'];
             $newMenu[$value['id']]['footer'] = $value['footer'];
			 }



        $file = public_path('menus/json_file/').'mainMenu.json';
        $handle = @fopen($file, 'w'); // Open the file for writing

        if ($handle) {
            @fwrite($handle, '{"menuArr":'.json_encode($newMenu).'}'); // Write to the file
            @fclose($handle); // Close the file
        }
     /////////////////////////////////////////////////////////////////////

        return redirect('admin/menu')->with('success', 'menu Successfully added!');
    }


    public function show($id)
    {

        if(!Utility::permissionCheck('view-menu'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        $menu = menu::findOrFail($id);

        return view('admin.menu.show', compact('menu'));
    }



    public function edit($id)
    {
        if(!Utility::permissionCheck('update-menu'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

       // $menu = menu::findOrFail($id);

       // return view('/pages/.menu.edit', compact('menu'));
		 $status = Helper::statusList();
		 $data = array();
        $menu = menu::findOrFail($id);
		$menus = menu::all(); // DB::table('categories')->where('status', 1)->get();
	    $permissions =  permission::all('name');

		$menu->permission_class = explode(',',$menu->permission_class );
       // print_r($menu['permission_class']);
        return view('admin.menu.edit',   ['menu' => $menu,'menus' => $menus ,'status'=>$status, 'permissions'=>$permissions]  );
    }



    public function update(Request $request, $id)
    {
        if(!Utility::permissionCheck('update-menu'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        $menu = menu::findOrFail($id);

        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();
         $requestData['permission_class'] = (!empty($requestData['permission_class']))?implode(',',$requestData['permission_class'] ):'';
        $requestData['left'] = ($request->left == 1)? 1 : 0;
        $requestData['top'] = ($request->top == 1)? 1 : 0;
        $requestData['footer'] = ($request->footer == 1)? 1 : 0;

        $menu->update($requestData);
		 /////////////////////////////write Jason//////////////////////////////////
		 $menus = menu::select('id','title','parent_id','route','permission_class','admin_left_section','icon','options','status')->where('status', 1)->where('left', 1)->get();
		 $newMenu = array();
		 foreach($menus as $key=>$value){
			 $newMenu[$value['id']]['title'] = $value['title'];
			 $newMenu[$value['id']]['parent_id'] = $value['parent_id'];
			 $newMenu[$value['id']]['route'] = $value['route'];
             $newMenu[$value['id']]['admin_left_section'] = $value['admin_left_section'];
			 $newMenu[$value['id']]['permission_class'] = $value['permission_class'];
			 $newMenu[$value['id']]['icon'] = $value['icon'];
			 $newMenu[$value['id']]['options'] = $value['options'];
			 $newMenu[$value['id']]['top'] = $value['top'];
			 $newMenu[$value['id']]['left'] = $value['left'];
			 $newMenu[$value['id']]['footer'] = $value['footer'];
			 }

        $file = public_path('menus/json_file/').'mainMenu.json';
        $handle = @fopen($file, 'w'); // Open the file for writing

        if ($handle) {
            @fwrite($handle, '{"menuArr":'.json_encode($newMenu).'}'); // Write to the file
            @fclose($handle); // Close the file
        }
     /////////////////////////////////////////////////////////////////////

      return redirect('admin/menu')->with('success', 'menu updated Successfully!');
    }



    public function destroy($id)
    {
        if(!Utility::permissionCheck('delete-menu'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        $menu = menu::findOrFail($id);

        $menu->delete();

        return redirect('admin/menu')->with('success', 'menu deleted Successfully!');
    }
}

