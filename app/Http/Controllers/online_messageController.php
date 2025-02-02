<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\online_message;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class online_messageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-online_messages'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $online_messages = online_message::where('message_type', 'LIKE', "%$keyword%")
                ->orWhere('offline_title', 'LIKE', "%$keyword%")
                ->orWhere('offline_message', 'LIKE', "%$keyword%")
                ->orWhere('message', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $online_messages = online_message::latest()->paginate($perPage);
        }

        return view('/admin/.online_messages.index', compact('online_messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-online_messages'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.online_messages.create');
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
     if(!Utility::permissionCheck('create-online_messages'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'message_type' => 'code'
		]);
        $requestData = $request->all();

        online_message::create($requestData);

        return redirect('online_messages')->with('flash_message', 'online_message added!');
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
    if(!Utility::permissionCheck('view-online_messages'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $online_message = online_message::findOrFail($id);

        return view('/admin/.online_messages.show', compact('online_message'));
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

     if(!Utility::permissionCheck('update-online_messages'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $online_message = online_message::findOrFail($id);

        return view('/admin/.online_messages.edit', compact('online_message'));
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

     if(!Utility::permissionCheck('update-online_messages'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'message_type' => 'code'
		]);
        $requestData = $request->all();

        $online_message = online_message::findOrFail($id);
        $online_message->update($requestData);

        return redirect('online_messages')->with('flash_message', 'online_message updated!');
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
     if(!Utility::permissionCheck('delete-online_messages'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        online_message::destroy($id);

        return redirect('online_messages')->with('flash_message', 'online_message deleted!');
    }
}
