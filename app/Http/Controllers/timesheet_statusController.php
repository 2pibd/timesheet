<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\flag_color;
use App\Utility\Utility;
use App\Models\timesheet_status;
use Illuminate\Http\Request;

class timesheet_statusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-timesheet_status'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $timesheet_status = timesheet_status::where('code', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->orWhere('details', 'LIKE', "%$keyword%")
                ->orWhere('flag', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $timesheet_status = timesheet_status::latest()->paginate($perPage);
        }

        return view('/admin/.timesheet_status.index', compact('timesheet_status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-timesheet_status'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
       $data['flag_colors'] =flag_color::get();
        return view('/admin/.timesheet_status.create', $data);
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
     if(!Utility::permissionCheck('create-timesheet_status'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'color_code' => 'color_code'
		]);
        $requestData = $request->all();

        timesheet_status::create($requestData);

        return redirect('admin/timesheet_status')->with('flash_message', 'timesheet_status added!');
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
    if(!Utility::permissionCheck('view-timesheet_status'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $timesheet_status = timesheet_status::findOrFail($id);

        return view('/admin/.timesheet_status.show', compact('timesheet_status'));
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

     if(!Utility::permissionCheck('update-timesheet_status'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['timesheet_status'] = timesheet_status::findOrFail($id);
        $data['flag_colors'] =flag_color::get();

        return view('/admin/.timesheet_status.edit', $data);
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

     if(!Utility::permissionCheck('update-timesheet_status'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'color_code' => 'color_code'
		]);
        $requestData = $request->all();

        $timesheet_status = timesheet_status::findOrFail($id);
        $timesheet_status->update($requestData);

        return redirect('admin/timesheet_status')->with('flash_message', 'timesheet_status updated!');
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
     if(!Utility::permissionCheck('delete-timesheet_status'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        timesheet_status::destroy($id);

        return redirect('admin/timesheet_status')->with('flash_message', 'timesheet_status deleted!');
    }
}
