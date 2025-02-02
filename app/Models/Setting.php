<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Setting extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    //protected $table = 'settings';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'sub_key', 'value'];

    public static function getHeaderText(){

        $setting = Setting::where('key', 'header_text')->first();
        if($setting){
            return $setting->value;
        }
        return 'Dactarbari';
    }

    public static function getByKey($key){

        $setting = Setting::where('key', $key)->first();
        if($setting){
            return $setting->value;
        }
        return false;
    }

    public static function getCurrency(){

        $currencies  = currency::where('status', '=', '1')->get() ;
        return $currencies;
    }


    public static function getLanguages(){

        $languages  = language::where('status', '=', '1')->get() ;
        return $languages;
    }

    public static  function loadUserMenu()

    {

        $user = Auth::user();

        $auth = $user->roles->toArray();

        $uid = $auth[0]['id'];



        ///////////////readinto file json//////////////////////

        $file = public_path('menus/json_file/').$uid.'.json';

        $data = file_get_contents($file);

        $dataArr = json_decode($data,true);

        $userJson =   $dataArr['menuArr'];



        return $userJson;

        //////////////////////////////////////////////////////



    }

    public static  function loadMainMenu()

    {

        ///////////////readinto file json//////////////////////

        $file = public_path('menus/json_file/').'mainMenu.json';

        $data = file_get_contents($file);

        $dataArr = json_decode($data,true);

        $mainJson =   $dataArr['menuArr'];

        //////////////////////////////////////////////////////

        return $mainJson ;

    }




    public static function getFooterText(){

        $setting = Setting::where('key', 'footer_text')->first();
        if($setting){
            return $setting->value;
        }
        return '&copy; QuickBD';
    }


    public static function getLogo(){

        $setting = Setting::where('key', 'logo_image')->first();
        if($setting){
            return asset('backEnd/img/'.$setting->value);
        }
        return asset('backEnd/img/logo.png');
    }

    public static function getCompanyName(){

        $setting = Setting::where('key', 'company_name')->first();
        if($setting){
            return $setting->value;
        }
        return 'Dactarbari';
    }

}
