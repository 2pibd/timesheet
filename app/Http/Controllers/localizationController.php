<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class localizationController extends Controller
{

    public function load_state(Request $request){
        $state = State::select('state','state_id')->where('country_id', $request->id)->get();
        return $state;
    }

    public function load_city(Request $request){
        $city = City::select('city','city_id')->where('state_id', $request->id)->get();
        return $city;
    }

}
