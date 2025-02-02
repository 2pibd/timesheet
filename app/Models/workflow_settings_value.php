<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class workflow_settings_value extends Model
{
    //

    protected $fillable = ['setting_id', 'role_id','role_name'];

    public function settings(){
        return $this->belongsTo('App\workflow_setting','workflow_id' );
    }


}
