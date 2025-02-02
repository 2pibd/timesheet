<?php


namespace App\Http\Controllers\Api;


use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

Use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\File;

use App\Models\User;

use Illuminate\Support\Facades\Auth;



use Validator;


class AuthController extends Controller
{


    public $successStatus = 200;


    public function loginXX(Request $request)
    {


        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

            $user = Auth::user();

            $user->api_token = $success['api_token'] = $user->createToken('hFh6jehSK6XLum1DEQLTjHB03lBjS6urLq3LTpPx')->accessToken;
            $user->Save();
            $success['fbid'] = $user->fbid;

            return response()->json(['success' => $success], $this->successStatus);

        } else {

            return response()->json(['error' => 'Unauthorised'], 401);

        }

    }
    // Login method
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }



    public function register(Request $request)
    {


        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        //$input['account_id'] =  date('y').strtoupper(uniqid());


        $user = User::create($input);

        $success['token'] = $user->createToken('hFh6jehSK6XLum1DEQLTjHB03lBjS6urLq3LTpPx')->accessToken;

        $success['name'] = $user->name;

        $success['fbid'] = $user->fbid;


        return response()->json(['success' => $success], $this->successStatus);

    }


    public function details()

    {

        $user = Auth::user();

        return response()->json(['success' => $user], $this->successStatus);

    }


    public function uploadDoc(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'fbid' => 'required',

        ]);


        $nid = $request->file('nid');

        $image_url = '';

        $path = 'profileImage/';

        if (isset($nid)) {

            $image_name = $request->fbid . '_nid_.' . $nid->getClientOriginalExtension();

            $upload_path = public_path($path);

            $nid->move($upload_path, $image_name);

            $image_url = $upload_path . $image_name;

            basic::image_size_fix($image_url, 600, 600);

            $data['nid'] = $path . $image_name;

        }


        $photo = $request->file('photo');

        $image_url = '';

        if (isset($photo)) {

            $image_name = $request->fbid . '_pic_.' . $photo->getClientOriginalExtension();

            $upload_path = public_path($path);

            $photo->move($upload_path, $image_name);

            $image_url = $upload_path . $image_name;

            basic::image_size_fix($image_url, 100, 100);

            $data['photo'] = $path . $image_name;

        }


        $driving_licence = $request->file('driving_licence');

        $image_url = '';

        if (isset($driving_licence)) {

            $image_name = $request->fbid . '_licence_.' . $driving_licence->getClientOriginalExtension();

            $upload_path = public_path($path);

            $driving_licence->move($upload_path, $image_name);

            $image_url = $upload_path . $image_name;

            basic::image_size_fix($image_url, 600, 800);

            $data['licence'] = $path . $image_name;

        }


    }


}

