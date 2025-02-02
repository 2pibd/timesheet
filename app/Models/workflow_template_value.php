<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class workflow_template_value extends Model
{
    protected $table = 'workflow_template_values';

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
    protected $fillable = ['workflow_template_id', 'workflow_role', 'value' ];

    public function setting_value(){
        return $this->belongsTo('App\workflow_settings_value','workflow_role' );
    }

}
