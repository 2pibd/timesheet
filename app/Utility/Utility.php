<?php

/**

 * Created by PhpStorm.

 * User: QuickBD

 * Date: 3/16/2019

 * Time: 08:35 PM

 */

namespace App\Utility;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Utility

{

    public static function permissionCheck($permission){

        if(auth()->user()->hasPermissionTo($permission))

        {

            return true;

        }

        return false;

    }



    public static function getPermissionMsg(){



        return 'Sorry ! Access Denied for Permission Issue';

    }



}
