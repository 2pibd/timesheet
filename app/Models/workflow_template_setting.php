<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class workflow_template_setting extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workflow_template_settings';

    /**
    * The database primary key value.w
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'ext_ref', 'company_id', 'workflow_id'];

    public function settings(){
        return $this->belongsTo('App\workflow_setting','workflow_id' );
    }

    public function workflow_template_value(){
        return $this->hasMany('App\workflow_template_value','workflow_template_id' );
    }

}
