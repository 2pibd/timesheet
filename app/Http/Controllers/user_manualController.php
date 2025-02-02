<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\user_manual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class user_manualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-user_manual'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $user_manual = user_manual::where('name', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->orWhere('file', 'LIKE', "%$keyword%")
                ->orWhere('visible_to', 'LIKE', "%$keyword%")
                ->orWhere('file', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $user_manual = user_manual::latest()->paginate($perPage);
        }

        return view('/admin/.user_manual.index', compact('user_manual'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-user_manual'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['status'] = Helper::getEnumValues('user_manuals','status');
        return view('/admin/.user_manual.create', $data);
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
     if(!Utility::permissionCheck('create-user_manual'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();
        $requestData['client'] = $request->client ? '1': '0';
        $requestData['worker'] = $request->worker ? '1': '0';
        $requestData['supplier'] = $request->supplier ? '1': '0';
        $requestData['consultant'] = $request->consultant ? '1': '0';
        user_manual::create($requestData);

        return redirect('admin/user_manual')->with('flash_message', 'user_manual added!');
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
    if(!Utility::permissionCheck('view-user_manual'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $user_manual = user_manual::findOrFail($id);

        return view('/admin/.user_manual.show', compact('user_manual'));
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

     if(!Utility::permissionCheck('update-user_manual'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['user_manual'] = user_manual::findOrFail($id);
        $data['status'] = Helper::getEnumValues('user_manuals','status');
        return view('/admin/.user_manual.edit', $data);
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

     if(!Utility::permissionCheck('update-user_manual'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();
        $requestData['client'] = $request->client ? '1': '0';
        $requestData['worker'] = $request->worker ? '1': '0';
        $requestData['supplier'] = $request->supplier ? '1': '0';
        $requestData['consultant'] = $request->consultant ? '1': '0';
        $user_manual = user_manual::findOrFail($id);
        $user_manual->update($requestData);

        return redirect('admin/user_manual')->with('flash_message', 'user_manual updated!');
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
     if(!Utility::permissionCheck('delete-user_manual'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        user_manual::destroy($id);

        return redirect('admin/user_manual')->with('flash_message', 'user_manual deleted!');
    }

    public function update_user_manual(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:user_manuals,id', // Ensure the ID exists in the faqs table
            'area' => 'required|string',             // Area should be a string
            'value' => 'required|boolean',           // Value should be a boolean
        ]);

        // Perform the update
        $result =  user_manual::where('id', $validatedData['id'])
            ->update([$validatedData['area'] => $validatedData['value']]);

        // Check if the update was successful
        if ($result) {
            return response()->json(['message' => 'Flag updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to update flag'], 500);
        }
    }



    public function revertUsermanual(Request $request)
    {
        $filePath = $request->get('file'); // Get the file path sent by FilePond

        if ($filePath && Storage::disk('public')->exists($filePath)) {
            // Delete the file from storage
            Storage::disk('public')->delete($filePath);

            // Optionally, update the database to remove the favicon reference
            $settings = user_manual::where('file',$request->id)->first();
            $settings->value = null;
            $settings->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'File not found'], 404);
    }


    public function uploadUsermanual(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:png,jpg,jpeg,gif,pdf,doc,docx,xlsx|max:2048',
        ]);

        // Store the logo in the 'logos' folder within the public storage
        $filePath = "/storage/".$request->file('file')->store('user_manual', 'public');

        // Return the path of the uploaded logo
        return  $filePath   ;
    }


}
