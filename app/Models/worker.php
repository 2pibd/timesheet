<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class worker extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workers';

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
    protected $fillable = ['user_id', 'employer_id','department_id','division_id','supplier_id','consultant_id',
        'employer_type_id', 'personal_ref', 'name_title', 'first_name', 'middle_name', 'last_name', 'surname', 'paye_code',
        'ni_number', 'gender',  'address_line1', 'address_line2', 'address_line3', 'address_line4', 'address_line5', 'post_code', 'country_id',
        'tel_number', 'mobile_number', 'email', 'dob', 'work_type', 'awr_type', 'non_cis_utr', 'known_as', 'status'];

    public function client(){
        return  $this->belongsTo('App\Models\client', 'employer_id');
    }

    public function supplier_type(){
        return  $this->belongsTo('App\Models\placement_type', 'supplier_type');
    }
    public function profile(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function worktype(){
        return  $this->belongsTo('App\Models\work_type', 'work_type');
    }
}
