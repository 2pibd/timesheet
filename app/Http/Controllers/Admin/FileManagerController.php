<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Auth;
use File;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FileManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');


    }

    public function index()
    {

        return view('admin.settings.files_manager' );
    }

    public function manager(Request $request)
    {

        return view('admin.settings.file_manager');
    }
}
