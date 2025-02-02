<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\employer;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\faq;

class faqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $data['activeMenu'] = 'faq';
        $query =  faq::query();

        $keyword = request()->search ;

        if(isset($keyword) && !empty($keyword))
        {
            $query->where('faq_title','LIKE','%'.$keyword.'%')
                ->orwhere('faq_desc','LIKE','%'.$keyword.'%')
                ->orwhere('category','LIKE','%'.$keyword.'%');
        }

        $data['faq'] = $query->paginate(10);

        return view('admin.faq.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $data['activeMenu']  = 'faq';
       $data['statusField'] = Helper::getEnumValues('faqs','category');
       $data['languages'] = language::where('display_default','1')->get();
        $data['employers'] = employer::get();
        return view('admin.faq.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = $request->all();
        $store['client'] = $request->client ? '1': '0';
        $store['worker'] = $request->worker ? '1': '0';
        $store['supplier'] = $request->supplier ? '1': '0';
        faq::create($store);
        return redirect('admin/faq');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['activeMenu'] ='faq';
        $data['faq'] = faq::find($id);
        $data['statusField'] = Helper::getEnumValues('faqs','category');
        $data['languages'] = language::where('display_default','1')->get();
        $data['employers'] = employer::get();
        return view('admin.faq.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $store = $request->all();

        $data = faq::find($id);
        $store['client'] = $request->client ? '1': '0';
        $store['worker'] = $request->worker ? '1': '0';
        $store['supplier'] = $request->supplier ? '1': '0';
        $data->update($store);
        return redirect('admin/faq');
    }

    public function update_flag(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:faqs,id', // Ensure the ID exists in the faqs table
            'area' => 'required|string',             // Area should be a string
            'value' => 'required|boolean',           // Value should be a boolean
        ]);

        // Perform the update
        $result = faq::where('id', $validatedData['id'])
            ->update([$validatedData['area'] => $validatedData['value']]);

        // Check if the update was successful
        if ($result) {
            return response()->json(['message' => 'Flag updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to update flag'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        faq::find($id)->delete();
        return redirect('faq-back');
    }
}
