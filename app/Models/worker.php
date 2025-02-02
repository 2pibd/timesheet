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
    protected $fillable = ['user_login_id', 'emp_ref', 'personal_ref', 'first_forename', 'second_forename', 'third_forename', 'surname', 'paye_code', 'ni_number', 'gender', 'address_line1', 'address_line2', 'address_line3', 'address_line4', 'address_line5', 'post_code', 'country_id', 'tel_number', 'mobile_number', 'email', 'dob', 'worker_type', 'awr_type', 'non_cis_utr', 'known_as', 'status'];

    
}
