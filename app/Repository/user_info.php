<?php
namespace App\Repository;


use App\Helpers\Helper;
use App\Models\User;
use Carbon\Carbon;
use Auth;
class user_info
{
    CONST CACHE_KEY = 'users';


    public function recruiters_users($uid)
    {
        $cacheKey = "tree_view.{$uid}";
        $key = $this->getCacheKey($cacheKey);

        $alluser = User::whereHas(
            'roles', function($q){
            $q->where('user_role_group_id', '1');
        }
        )->leftJoin('user_addresses','user_addresses.user_id','=','users.id')
            ->where('user_addresses.address_type','Present')->get();

        $array = array();

        foreach ($alluser as $key => $value) {
            $array[$value['id']] = array(
                "id" => $value['id'],
                "parent_id" => $value['parent_user_id'],
                "name" => $value['name'] ,
                "email" => $value['email'],
                "phone" => $value['phone_no'],
                "currency" => $value['currency'],
                "address" => $value['address'],
                "address2" => $value['address2'],
                "address3" => $value['address3'],
                "address4" => $value['address4'],
                "address5" => $value['address5'],
                "city" => $value['city'],
                "state" => $value['state'],
                "post_code" => $value['zip_code'],
                "country" => $value['country'],
                "role" => $value->getRoleNames()->first());
        }

           $Result= Helper::createTreeViewArr($array, $uid, '');


        return  cache()->remember($cacheKey, Carbon::now()->addMinutes(5), function () use($Result){
            return $Result;
        });


    }



    public function getCacheKey($key){
        $key = strtoupper($key);
        return self::CACHE_KEY .".$key";
    }
}
?>
