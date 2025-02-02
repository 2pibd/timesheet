<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\escalation_frequency;
use Illuminate\Http\Request;

class escalation_frequencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

     if(!Utility::permissionCheck('view-escalation_frequency'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }



        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $escalation_frequency = escalation_frequency::where('description', 'LIKE', "%$keyword%")
                ->orWhere('monday', 'LIKE', "%$keyword%")
                ->orWhere('tuesday', 'LIKE', "%$keyword%")
                ->orWhere('wednesday', 'LIKE', "%$keyword%")
                ->orWhere('thursday', 'LIKE', "%$keyword%")
                ->orWhere('friday', 'LIKE', "%$keyword%")
                ->orWhere('saturday', 'LIKE', "%$keyword%")
                ->orWhere('sunday', 'LIKE', "%$keyword%")
                ->orWhere('start_time', 'LIKE', "%$keyword%")
                ->orWhere('end_time', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
             $escalation_frequency = escalation_frequency::latest()->paginate($perPage);
        }

        return view('/admin/.escalation_frequency.index', compact('escalation_frequency'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-escalation_frequency'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.escalation_frequency.create');
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
     if(!Utility::permissionCheck('create-escalation_frequency'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'description' => 'required'
		]);

        $requestData = $request->all();
        $requestData['monday'] = $request->monday ? '1': '0';
        $requestData['tuesday'] = $request->tuesday ? '1': '0';
        $requestData['wednesday'] = $request->wednesday ? '1': '0';
        $requestData['thursday'] = $request->thursday ? '1': '0';
        $requestData['friday'] = $request->friday ? '1': '0';
        $requestData['saturday'] = $request->saturday ? '1': '0';
        $requestData['sunday'] = $request->sunday ? '1': '0';

        escalation_frequency::create($requestData);

        return redirect('/admin/escalation_frequency')->with('flash_message', 'escalation_frequency added!');
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
    if(!Utility::permissionCheck('view-escalation_frequency'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $escalation_frequency = escalation_frequency::findOrFail($id);

        return view('/admin/.escalation_frequency.show', compact('escalation_frequency'));
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

     if(!Utility::permissionCheck('update-escalation_frequency'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $escalation_frequency = escalation_frequency::findOrFail($id);

        return view('/admin/.escalation_frequency.edit', compact('escalation_frequency'));
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

     if(!Utility::permissionCheck('update-escalation_frequency'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'description' => 'required'
		]);
        $requestData = $request->all();
        $requestData['monday'] = $request->monday ? '1': '0';
        $requestData['tuesday'] = $request->tuesday ? '1': '0';
        $requestData['wednesday'] = $request->wednesday ? '1': '0';
        $requestData['thursday'] = $request->thursday ? '1': '0';
        $requestData['friday'] = $request->friday ? '1': '0';
        $requestData['saturday'] = $request->saturday ? '1': '0';
        $requestData['sunday'] = $request->sunday ? '1': '0';

        $escalation_frequency = escalation_frequency::findOrFail($id);
        $escalation_frequency->update($requestData);

        return redirect('/admin/escalation_frequency')->with('flash_message', 'escalation_frequency updated!');
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
     if(!Utility::permissionCheck('delete-escalation_frequency'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        escalation_frequency::destroy($id);

        return redirect('admin/escalation_frequency')->with('flash_message', 'escalation_frequency deleted!');
    }


    public function update_escalation_frequency(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:user_manuals,id', // Ensure the ID exists in the faqs table
            'area' => 'required|string',             // Area should be a string
            'value' => 'required|boolean',           // Value should be a boolean
        ]);

        // Perform the update
        $result =  escalation_frequency::where('id', $validatedData['id'])
            ->update([$validatedData['area'] => $validatedData['value']]);

        // Check if the update was successful
        if ($result) {
            return response()->json(['message' => 'Flag updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to update flag'], 500);
        }
    }
}
