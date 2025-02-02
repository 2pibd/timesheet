<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class workflow_setting extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workflow_settings';

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
    protected $fillable = ['segment_structure_id', 'workflow_type_id', 'user_id', 'title', 'ext_ref', 'setup'];


    public function getoptions(){
        return $this->hasMany('App\workflow_settings_value','setting_id' );
    }

    public function workflowType(){
        return $this->belongsTo('App\workflow_type','workflow_type_id' );
    }


}
