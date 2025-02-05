<?php

namespace App\Http\Controllers;


use App\Models\company_contact_info_phone;
use App\Helpers\Helper;
use App\Models\client;
use App\Models\client_type;
use App\Models\company_address;
use App\Models\company_contact_email;
use App\Models\company_contact_info;
use App\Models\Country;
use App\Models\Currency;
use App\Models\industry;
use App\Models\Language;
use App\Models\name_title;
use App\Models\User;
use App\Utility\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;
class clientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Utility::permissionCheck('view-client')) {
            return back()->with('error', Utility::getPermissionMsg());
        }


        return view('/admin/.client.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Utility::permissionCheck('create-client')) {
            return back()->with('error', Utility::getPermissionMsg());
        }

        $data['client_types'] = client_type::get();
        $data['currencies'] = Currency::get();
        $data['countries'] = Country::where('lang', 'en')->get();
        $data['industries'] = industry::orderBy('industry')->get();
        $data['allTabActive'] = false;
        $data['param'] = 0;
        $data['languages'] = Language::where('display_default', '1')->get();

        //$data['compliance_groups'] = compliance_group::get();
        $data['status'] = Helper::getEnumValues('clients','status');
        $data['name_titles'] = name_title::all();
        return view('/admin/.client.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Utility::permissionCheck('create-client'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }
        $this->validate($request, [
            'company_name' => 'required'
        ]);
         $requestData = $request->all();

         $requestData['post_by'] = Auth::id();

        client::create($requestData);

        return redirect('admin/client')->with('flash_message', 'Client added!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['client'] = client::findOrFail($id);

        $data['client_types'] = client_type::get();
        $data['currencies'] = Currency::get();
        $data['countries'] = Country::where('lang', 'en')->get();
        $data['industries'] = industry::orderBy('industry')->get();
        $data['allTabActive'] = true;
        $data['param'] = 0;
        $data['languages'] = Language::where('display_default', '1')->get();

        //$data['compliance_groups'] = compliance_group::get();
        $data['status'] = Helper::getEnumValues('clients','status');

        $data['address'] = company_address::where('company_id', $id)->get();
        $data['contact_info'] = company_contact_info::where('company_id', $id)->get();
        $data['name_titles'] = name_title::all();
        return view('/admin/.client.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if(!Utility::permissionCheck('update-client'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }


        $this->validate($request, [
            'company_name' => 'required'
        ]);
        $requestData = $request->all();

         $client = client::findOrFail($id);

         $client->update($requestData);

        return redirect('admin/client')->with('flash_message', 'Client updated!');
    }

    public function loginAccess(Request $request)
    {
        if(!Utility::permissionCheck('update-client'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }


        $this->validate($request, [
            'client_id' => 'required'
        ]);

         $requestData = $request->all();

        $client = client::findOrFail($request->client_id);
          /////////////////////////////////
        if($client){
            $userData = $request->all();
            $userData['name'] = $request->name_title . '  ' . $request->first_name . '  ' . $request->middle_name . '  ' . $request->last_name;

            $userData['status'] =  $request->status ? 'Active': 'Inactive';

            $userData['remember_token'] = md5(time());
            $userData['password'] = (!empty($request->password)) ? bcrypt($request->password) : '';

            $user = User::updateOrCreate([
                'id'=> $client->user_id
            ],$userData);

            $user->syncRoles('Client');
            $clientData['user_id'] = $user->id;
            $client->update($clientData);
            $status = ([
                'status'=>'success',
                'message'=> 'Save Successfully'
            ]);

        }else

        $status = ([
            'status'=>'failed',
            'message'=> 'Failed to save'
        ]);

        return  $status;
    }



    public function revertClientLogo(Request $request)
    {
        $filePath = $request->get('file'); // Get the file path sent by FilePond

        if ($filePath && Storage::disk('public')->exists($filePath)) {
            // Delete the file from storage
            Storage::disk('public')->delete($filePath);

            // Optionally, update the database to remove the favicon reference
            $client = client::where('id',$request->id)->first();
            $client->value = null;
            $client->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'File not found'], 404);
    }

    public function check_email(Request $request)
    {

    }

    public function uploadClientLogo(Request $request)
    {
        $request->validate([
            'company_logo' => 'required|image|mimes:png,jpg,jpeg,gif,pdf,doc,docx,xlsx|max:2048',
        ]);

        // Store the logo in the 'logos' folder within the public storage
        $filePath = "/storage/". $request->file('company_logo')->store('client/logo', 'public');

        // Return the path of the uploaded logo
        return  $filePath   ;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if(!Utility::permissionCheck('delete-client'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        try {
            client::destroy($id);
        } catch (\Exception $e) {

            return redirect('admin.client')->with('error', 'There is a problem in Deleting Client!');
        }

        return redirect('admin.client')->with('success', 'Client deleted!');
    }

    public function loadContactForm(Request $request)
    {
        $data['company_id'] = $request->company_id;
        $data['contacts'] = company_contact_info::with(['emails','phones'=>function($q){
            $q ->select(DB::raw('*,CONCAT(phone_code, phone) as phone_number'));
        }])->where('company_id', $request->company_id)->where('id', $request->id)->first();

        $data['addresses'] = company_address::select(DB::raw('*, CONCAT_WS(", ", address1,address2,address3,address4,address5,city,state,postcode,country) AS address'))->where('company_id', $request->company_id)->get();
        $data['name_titles'] = name_title::all();
        return view('/admin/.client.contact_person_form', $data);
    }



    public function save_contact_person(Request $request)
    {
        if ($request) {

            if ($request->is_default == 1 && !empty($request->company_id)) {
                company_contact_info::where('company_id', $request->company_id)->update(array('is_default' => 0));
            }

            $requestData = $request->all();
            if ($request->hasFile('business_card')) {
                $image = $request->file('business_card');
                $name = time() . '.' . $image->getClientOriginalExtension();

                $img_dir = 'business_card/';
                $image->storeAs('business_card/', $name ,'s3');

                $requestData['business_card'] = $img_dir . $name;
            }

            $company_profile = client::where('id',$request->company_id)->first();
            $requestData['contact_name'] = $request->name_title.' '.$request->first_name.' '.$request->middle_name.' '.$request->last_name;

            $result = company_contact_info::updateOrCreate(
                [
                    'id' => $request->id,
                ],
                $requestData
            );

            $emails = '';

            if (isset($request->head)) {
                foreach ($request->head as $key => $item) {
                    company_contact_email::updateOrCreate(
                        [
                            'id' => $item['id'],
                        ],
                        [
                            'company_contact_id' => $result->id,
                            'email' => $item['email'],
                            'default' => ($request['email_default'] == $key) ? 1 : 0,
                        ]);
                    $emailArr[] = $item['email'];
                }
                $emails  = @implode(',',$emailArr);
            }


            if (isset($request->phone)) {
                foreach ($request->phone as $key => $item) {
                    $cc = company_contact_info_phone::updateOrCreate(
                        [
                            'id' => $item['id'],
                        ],
                        [
                            'company_contact_info_id' => $result->id,
                            'phone_code' => $item['phone_code'],
                            'phone' => $item['phone'],
                            'type' => $item['type'],
                            'is_default' =>($request['phone_default'] == $key) ? 1 : 0,
                        ]);

                    $phoneArr[] =  $item['phone_code'].$item['phone'];
                }
                // $phones  = @implode(',',$phoneArr);

            }
            // return $result;
            return $status=([
                'status'=>'success',
                'message'=>'Save Successfully'
            ]);
        }
    }

    public function delete_comContact($id, Request $request)
    {
        $companyContactDel = company_contact_info::where('id', $id)->where('company_id', $request->company_id)->delete();
        return $result=([
            'status'=>'success',
            'message'=>'Removed Successfully'
        ]);
    }


/////////////////////////////////////////////////////////////////////////////////////////////////////
    public function loadAddressForm(Request $request)
    {
        $data['company_id'] = $request->company_id;
        $data['address'] = company_address::where('company_id', $request->company_id)->where('id', $request->id)->first();
         $data['country'] = country::where('lang', 'en')->get();
        return view('/admin/.client.address_form', $data);
    }

    public function save_company_address(Request $request)
    {
        if ($request) {

            if ($request->is_default == 1 && !empty($request->company_id)) {

                company_address::where('company_id', $request->company_id)->update(array('is_default' => 0));

            }

            $company_profile = client::where('id',$request->company_id)->first();
            $result = company_address::updateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'company_id' => $request->company_id,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'address3' => $request->address3,
                    'address4' => $request->address4,
                    'address5' => $request->address5,
                    'city' => $request->city,
                    'state' => $request->state,
                    'postcode' => $request->postcode,
                    'country' => $request->country,
                    'is_default' => $request->is_default,
                    'address_type' => $request->address_type,
                ]);

            /////////////update company default Address/////
            if ($request->is_default == 1) {
                $company = client::updateOrCreate([
                    'id' => $request->company_id,
                ],
                    [
                        'address1' => $request->address1,
                        'address2' => $request->address2,
                        'address3' => $request->address3,
                        'address4' => $request->address4,
                        'address5' => $request->address5,
                        'city' => $request->city,
                        'state' => $request->state,
                        'postcode' => $request->postcode,
                        'country' => $request->country
                    ]);
            }

            ////////////add master address book//////
            $addressdata = array(
                'user_id' => Auth::id(),
                'address_type' => 'company',
                'first_name' => '',
                'last_name' => '',
                'company' => $company_profile->company_name,
                'position' => '',
                'address1' => $request->address1,
                'address2' => $request->address2,
                'address3' => $request->address3,
                'address4' => $request->address4,
                'address5' => $request->address5,
                'city' => $request->city,
                'state' => $request->state,
                'post_code' => $request->postcode,
                'country' => $request->country,
                'phone_number' => '',
                'mobile' =>$company_profile->company_phone,
                'email' => $company_profile->company_email,
                'website' => $company_profile->website
            );
         //   app('App\Http\Controllers\address_bookController')->addAddress($addressdata);

            return $result=([
                'status'=>'success',
                'message'=>'Save Successfully'
            ]);

        }
    }

    ////////////////////////////////////////////////////////////////////////////////

    public function delete_comAddress($id, Request $request)
    {
        $companyAddressDel = company_address::where('id', $id)->where('company_id', $request->company_id)->first();
        $companyAddressDel->delete();

        return $status=([
            'status'=>'success',
            'message'=>'Removed'
        ]);

    }


/////////////////////////////////////Company Contact Info////////////////////////////////////////////////////
    public function company_contacts(Request $request)
    {
        if ($request) {
            $data['contact_info'] = company_contact_info::with(['emails','phones'=>function($q){
                $q ->select(DB::raw('company_contact_info_id, CONCAT(phone_code, phone) as phone_number'));
            }])->where('company_id', $request->company_id)->get();
            return view('/admin/.client.company_contact_info', $data);
        }
    }

    public function company_address(Request $request)
    {
        if ($request) {
            $data['address'] = company_address::with('CountryLoad', 'StateLoad', 'CityLoad')->where('company_id', $request->company_id)->get();
            return view('/admin/.client.company_address', $data);
        }
    }

}
