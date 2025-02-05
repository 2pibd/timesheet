<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class consultant extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'consultants';

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
    protected $fillable = ['user_id', 'user_ref', 'ref_code', 'access_code', 'official_id', 'work_telephone', 'mobile_number', 'address_line1', 'address_line2', 'address_line3', 'address_line4', 'post_code', 'office_manager', 'security_admin', 'read_only_access', 'template_id', 'language_id'];


    public function profile(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
