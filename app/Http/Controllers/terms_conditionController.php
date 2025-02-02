<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\terms_condition;
use Illuminate\Http\Request;

class terms_conditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-terms_condition'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $terms_condition = terms_condition::where('title', 'LIKE', "%$keyword%")
                ->orWhere('type', 'LIKE', "%$keyword%")
                ->orWhere('details', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $terms_condition = terms_condition::latest()->paginate($perPage);
        }

        return view('/admin/.terms_condition.index', compact('terms_condition'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-terms_condition'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.terms_condition.create');
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
     if(!Utility::permissionCheck('create-terms_condition'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();
        
        terms_condition::create($requestData);

        return redirect('terms_condition')->with('flash_message', 'terms_condition added!');
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
    if(!Utility::permissionCheck('view-terms_condition'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $terms_condition = terms_condition::findOrFail($id);

        return view('/admin/.terms_condition.show', compact('terms_condition'));
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

     if(!Utility::permissionCheck('update-terms_condition'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $terms_condition = terms_condition::findOrFail($id);

        return view('/admin/.terms_condition.edit', compact('terms_condition'));
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

     if(!Utility::permissionCheck('update-terms_condition'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'title' => 'required'
		]);
        $requestData = $request->all();
        
        $terms_condition = terms_condition::findOrFail($id);
        $terms_condition->update($requestData);

        return redirect('terms_condition')->with('flash_message', 'terms_condition updated!');
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
     if(!Utility::permissionCheck('delete-terms_condition'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        terms_condition::destroy($id);

        return redirect('terms_condition')->with('flash_message', 'terms_condition deleted!');
    }
}
