<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class workflow extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workflows';

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
    protected $fillable = ['description', 'escalation_frequency_id', 'email_wet_signature', 'email_approval_signature',
        'sso_link_expiry_days', 'status'];


     public function escalation_frequency(){
        return $this->belongsTo('App\Models\escalation_frequency', 'escalation_frequency_id');
     }

}
