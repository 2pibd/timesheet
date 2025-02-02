<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Utility\Utility;
use App\Models\industry;
use Illuminate\Http\Request;

class industryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-industry'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $industry = industry::where('industry', 'LIKE', "%$keyword%")
                ->orWhere('is_active', 'LIKE', "%$keyword%")
                ->orWhere('sort_order', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $industry = industry::latest()->paginate($perPage);
        }

        return view('/admin/.industry.index', compact('industry'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-industry'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        return view('/admin/.industry.create');
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
     if(!Utility::permissionCheck('create-industry'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'industry' => 'required'
		]);
        $requestData = $request->all();
        
        industry::create($requestData);

        return redirect('industry')->with('flash_message', 'industry added!');
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
    if(!Utility::permissionCheck('view-industry'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $industry = industry::findOrFail($id);

        return view('/admin/.industry.show', compact('industry'));
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

     if(!Utility::permissionCheck('update-industry'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $industry = industry::findOrFail($id);

        return view('/admin/.industry.edit', compact('industry'));
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

     if(!Utility::permissionCheck('update-industry'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'industry' => 'required'
		]);
        $requestData = $request->all();
        
        $industry = industry::findOrFail($id);
        $industry->update($requestData);

        return redirect('industry')->with('flash_message', 'industry updated!');
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
     if(!Utility::permissionCheck('delete-industry'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        industry::destroy($id);

        return redirect('industry')->with('flash_message', 'industry deleted!');
    }
}
