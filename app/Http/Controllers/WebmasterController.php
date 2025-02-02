<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests;
use App\Models\Language;
use App\Models\Setting;
use App\Utility\Utility;
use Illuminate\Http\Request;
use File;
use  Image;
use Illuminate\Support\Facades\Storage;

use App\Models\time_zone;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Webklex\IMAP\Facades\Client;
use DB;
class WebmasterController extends Controller
{


    public function index()
    {
        if(!Utility::permissionCheck('view-setting'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

         $data['settings'] = (object) Setting::all()->pluck('value','key')->toArray();

        $data['languages'] =Language::where('is_active',1)->orderBy('lang','ASC')->get();
        $data['timezones'] =time_zone::orderBy('tz_name','ASC')->get();



        return view('admin.settings.index', $data);
    }



    public function revertLogo(Request $request)
    {
        $filePath = $request->get('file'); // Get the file path sent by FilePond

        if ($filePath && Storage::disk('public')->exists($filePath)) {
            // Delete the file from storage
            Storage::disk('public')->delete($filePath);

            // Optionally, update the database to remove the favicon reference
            $settings = Setting::where('key','logo')->first();
            $settings->value = null;
            $settings->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'File not found'], 404);
    }

    public function revertFavicon(Request $request)
    {
        $filePath = $request->get('file'); // Get the file path sent by FilePond

        if ($filePath && Storage::disk('public')->exists($filePath)) {
            // Delete the file from storage
            Storage::disk('public')->delete($filePath);

            // Optionally, update the database to remove the favicon reference
            $settings = Setting::where('key','favicon')->first();
            $settings->value = null;
            $settings->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'File not found'], 404);
    }

    public function saveData(Request $request)
    {
       // return $request;
   /*     $validated = $request->validate([
           // 'settings.site_title' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);*/
     $requestData = $request->all();

        foreach ($request->settings as $key=>$item){
            if($item!='[object File]')
            \DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' =>$item]
            );
        }
        // Update logo and favicon paths if they exist in the request
        if ($request->has('logo')) {
            if( $request->input('logo')!='[object File]')
            \DB::table('settings')->updateOrInsert(
                ['key' => 'logo'],
                ['value' => $request->input('logo')]
            );
        }

        if ($request->has('favicon')) {
            if( $request->input('favicon')!='[object File]')
            \DB::table('settings')->updateOrInsert(
                ['key' => 'favicon'],
                ['value' => $request->input('favicon')]
            );
        }

       return $status=[
            'status'=>'success',
            'message'=>'Successfully Submitted'
        ];

      //  return redirect()->back()->with('success', 'Data saved successfully with file upload.');
    }


    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,gif|max:2048',
        ]);

        // Store the logo in the 'logos' folder within the public storage
        $filePath = "/storage/".$request->file('logo')->store('logos', 'public');

        // Return the path of the uploaded logo
        return  $filePath   ;
    }

    public function uploadFavicon(Request $request)
    {
        $request->validate([
            'favicon' => 'required|image|mimes:png,jpg,jpeg,gif|max:1024',
        ]);

        // Store the favicon in the 'favicons' folder within the public storage
        $filePath = "/storage/".$request->file('favicon')->store('favicons', 'public');

        // Return the path of the uploaded favicon
        return  $filePath ;
    }


    public function create()
    {
        if(!Utility::permissionCheck('create-setting'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        return view('admin.setting.create');
    }


    public function store(Request $request)
    {
        if(!Utility::permissionCheck('create-setting'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        $this->validate($request, [
			'key' => 'required',
			'value' => 'required'
		]);

        $requestData = $request->all();

        if ($request->hasFile('image')) {
            $requestData['sub_key'] = 'image';
            $requestData['value'] = $this->uploadImage($request->file('image'));
        }

        Setting::create($requestData);

        return redirect('setting')->with('success', 'Setting Successfully added!');
    }


    public function show(Setting $setting)
    {
        if(!Utility::permissionCheck('view-setting'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        return view('admin.setting.show', compact('setting'));
    }



    public function edit(Setting $setting)
    {
        if(!Utility::permissionCheck('update-setting'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        //$setting = setting::findOrFail($setting);
        return view('admin.setting.edit', compact('setting'));
    }

    public function configSettings(Request $request)
    {

        $requestData['value'] =$request->value;
        setting::where( 'key'  , $request->key)->update($requestData);
        return 1;
    }


    public function update(Request $request, Setting $setting)
    {
        if(!Utility::permissionCheck('update-setting'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        $this->validate($request, [
			'key' => 'required',
			'value' => 'required'
		]);
        $requestData = $request->all();

        if($setting->key == 'footer_text' || $setting->key == 'header_text' ||
            $setting->key == 'logo_image'|| $setting->key == 'company_name'){

            unset($requestData['key']); // these setting key will not change, otherwise it cause Setting model failure.
            $message = 'Only Setting Value updated! Core Setting key will be unchanged';
        }

        if ($request->hasFile('image')) {
            $imagePath = storage_path('app/public/images/'. $setting->value);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $requestData['sub_key'] = 'image';
            $requestData['value'] = $this->uploadImage($request->file('image'));

        }

        $setting->update($requestData);

        return redirect('setting')->with('success', isset($message) ? $message : 'Setting is successfully updated');

    }



    public function destroy(Setting $setting)
    {
        if(!Utility::permissionCheck('delete-setting'))
        {
            return back()->with('error',Utility::getPermissionMsg());
        }

        if($setting->key == 'footer_text' || $setting->key == 'header_text' ||
            $setting->key == 'logo_image'|| $setting->key == 'company_name'){

            return redirect('setting')->with('warning', 'Core Settings cant be deleted');
        }

        try {
            $setting->delete();

        } catch (\Exception $e) {

            return redirect('setting')->with('error', 'There is a problem in Deleting Settings!');
        }

        return redirect('setting')->with('success', 'Setting deleted!');
    }


    /**
     * upload image to storage/app/public/ride
     */
    public function uploadImage($image){

        $imageName = uniqid() . time() . '.' . $image->getClientOriginalExtension();

        $directoryPath=storage_path('app/public/images');

        if(!File::isDirectory($directoryPath)){ // create the folder if not exist

            File::makeDirectory($directoryPath);
        }

        Image::make($image)->resize(300, null, function ($constraint) {

            $constraint->aspectRatio();

        })->save(storage_path('app/public/images/' . $imageName));

        return $imageName;
    }


    public function check_connection(Request $request){
          $action = $request->save_mailconfig;
        if($action == 'Save')
        foreach ($request->settings as $key=>$item){
            if($item!='[object File]')
                \DB::table('settings')->updateOrInsert(
                    ['key' => $key],
                    ['value' =>$item]
                );
        }


        try {

            $smtpServer = $request->settings['mail_host'];
            $username = $request->settings['mail_username'];
            $password = $request->settings['mail_password'];
            $port = $request->settings['mail_port'];
            $mail_encryption = $request->settings['mail_encryption'];
            $protocol = $request->settings['protocol'];

            $client = Client::make([
                'host'          => $smtpServer,
                'port'          => $port,
                'encryption'    => $mail_encryption,
                'validate_cert' => true,
                'username'      => $username,
                'password'      => $password,
                'protocol'      => $protocol,
            ]);

            $client->connect();
            return response()->json([
                'status' => 'success',
                'message' => 'SMTP Connection Checked Successfully!',
            ]);
            return "IMAP connection successful!";
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "IMAP connection failed: " . $e->getMessage()
            ]);
            //return "IMAP connection failed: " . $e->getMessage();
        }

    }

    public function mail_smtp_check(Request $request)
    {

        if ($request->settings['mail_driver'] == "smtp" && $request->settings['mail_host'] != "" && $request->settings['mail_port'] != "") {

            try {
                function server_parse($socket, $expected_response)
                {
                    $server_response = '';
                    while (substr($server_response, 3, 1) != ' ') {
                        if (!($server_response = fgets($socket, 256))) {
                            return 'Error while fetching server response codes';
                        }
                    }

                    if (!(substr($server_response, 0, 3) == $expected_response)) {
                        return $server_response;
                    }
                }

                //Connect to the host on the specified port
                $smtpServer = $request->settings['mail_host'];
                $username = $request->settings['mail_username'];
                $password = $request->settings['mail_password'];
                $port = $request->settings['mail_port'];

                $timeout = 20;
                $output = "";

                 $socket = fsockopen($smtpServer, $port, $errno, $errstr, $timeout);
                if (!$socket) {
                    return json_encode(array("stat" => "error", "error" => "$errstr ($errno)"));
                } else {

                    server_parse($socket, '220');

                    fwrite($socket, 'EHLO ' . $smtpServer . "\r\n");
                    $output .= server_parse($socket, '250');
                    if ($output != "") {
                        $output .= "<br>";
                    }
                    fwrite($socket, 'AUTH LOGIN' . "\r\n");
                    $output .= server_parse($socket, '334');
                    if ($output != "") {
                        $output .= "<br>";
                    }
                    fwrite($socket, base64_encode($username) . "\r\n");
                    $output .= server_parse($socket, '334');
                    if ($output != "") {
                        $output .= "<br>";
                    }
                    fwrite($socket, base64_encode($password) . "\r\n");
                    $output .= server_parse($socket, '235');

                    if ($output == "") {
                        return json_encode(array("stat" => "success"));
                    } else {
                        return json_encode(array("stat" => "error", "error" => $output));
                    }
                }
            } catch (\Exception $e) {
                return json_encode(array("stat" => "error", "error" => "$errstr ($errno)"));
            }
        }
        return json_encode(array("stat" => "error", "error" => "Failed .. no data to connect"));
    }

    public function mail_test(Request $request)
    {
        $WebmasterSetting = WebmasterSetting::find(1);
        if (!empty($WebmasterSetting)) {

            $WebmasterSetting->mail_driver = $request->mail_driver;
            $WebmasterSetting->mail_host = $request->mail_host;
            $WebmasterSetting->mail_port = $request->mail_port;
            $WebmasterSetting->mail_username = $request->mail_username;
            $WebmasterSetting->mail_password = $request->mail_password;
            $WebmasterSetting->mail_encryption = $request->mail_encryption;
            $WebmasterSetting->mail_no_replay = $request->mail_no_replay;
            $WebmasterSetting->save();


            $env_update = $this->changeEnv([
                'MAIL_DRIVER' => $request->mail_driver,
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => $request->mail_port,
                'MAIL_USERNAME' => $request->mail_username,
                'MAIL_PASSWORD' => $request->mail_password,
                'MAIL_ENCRYPTION' => $request->mail_encryption,
                'MAIL_FROM_ADDRESS' => $request->mail_no_replay,
            ]);

            if ($request->mail_driver == "smtp" && $request->mail_host != "" && $request->mail_port != "") {
                try {
                    $email_subject = "Test Mail From " . config('app.name');
                    $email_body = "This is a Test Mail <br>
Mail Driver: " . $request->mail_driver . "<br>
Mail Host: " . $request->mail_host . "<br>
Mail Port: " . $request->mail_port . "<br>
Mail Username: " . $request->mail_username . "<br>
Email from: " . $request->mail_no_replay . "<br>
Email to: " . $request->mail_test . "
";
                    $to_email = $request->mail_test;
                    $to_name = $request->mail_test;
                    $from_email = $request->mail_no_replay;
                    $from_name = config('app.name');

                    Mail::send('emails.template', [
                        'title' => $email_subject,
                        'details' => $email_body
                    ], function ($message) use ($email_subject, $to_email, $to_name, $from_email, $from_name) {
                        $message->from($from_email, $from_name);
                        $message->to($to_email);
                        $message->replyTo($from_email, $from_name);
                        $message->subject($email_subject);

                    });

                    return json_encode(array("stat" => "success"));
                } catch (\Exception $e) {
                    return json_encode(array("stat" => "error"));
                }
            }
        }
        return json_encode(array("stat" => "error"));
    }
}
