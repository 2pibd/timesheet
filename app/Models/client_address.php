<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class client_address extends Model
{
    //
    protected $table = 'client_addresses';

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
    protected $fillable = ['client_id', 'address_type', 'address1', 'address2','address3','address4','address5',
         'city', 'state', 'postcode', 'country', 'is_default' ];


    public function CountryLoad(){
        return $this->belongsTo('App\Models\Country', 'country', 'country_id');
    }

    public function StateLoad(){
        return $this->belongsTo('App\Models\State', 'state', 'state_id');
    }

    public function CityLoad(){
        return $this->belongsTo('App\Models\City', 'city', 'city_id');
    }


    public function company(){
        return $this->belongsTo('App\Models\client_contact_info',  'client_id');
    }



}
