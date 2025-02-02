<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\template_type;
use App\Utility\Utility;
use App\Models\email_template;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class email_templateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
     if(!Utility::permissionCheck('view-email_template'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }



        return view('/admin/.email_template.index'  );
    }
// app/Http/Controllers/EmailTemplateController.php



public function exportToPDF()
{
    $data = email_template::all();
    $pdf = PDF::loadView('email_templates.export', compact('data'));

    return $pdf->download('email_templates.pdf');
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    if(!Utility::permissionCheck('create-email_template'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $data['status'] = Helper::getEnumValues('email_templates', 'status');
        $data['template_types'] = template_type::get();
        return view('/admin/.email_template.create', $data);
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
     if(!Utility::permissionCheck('create-email_template'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }
        $this->validate($request, [
			'tplname' => 'required'
		]);
        $requestData = $request->all();

        email_template::create($requestData);

        return redirect('email_template')->with('flash_message', 'email_template added!');
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
    if(!Utility::permissionCheck('view-email_template'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $email_template = email_template::findOrFail($id);

        return view('/admin/.email_template.show', compact('email_template'));
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

     if(!Utility::permissionCheck('update-email_template'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        $data['email_template'] = email_template::findOrFail($id);
        $data['status'] = Helper::getEnumValues('email_templates', 'status');
        $data['template_types'] = template_type::get();
        return view('/admin/.email_template.edit',  $data);
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

     if(!Utility::permissionCheck('update-email_template'))
                {
                    return back()->with('error',Utility::getPermissionMsg());
                }


        $this->validate($request, [
			'tplname' => 'required'
		]);
        $requestData = $request->all();

        $email_template = email_template::findOrFail($id);
        $email_template->update($requestData);

        return redirect('email_template')->with('flash_message', 'email_template updated!');
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
     if(!Utility::permissionCheck('delete-email_template'))
            {
                return back()->with('error',Utility::getPermissionMsg());
            }

        email_template::destroy($id);

        return redirect('email_template')->with('flash_message', 'email_template deleted!');
    }
}
