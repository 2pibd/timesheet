<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class my_office extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'my_offices';

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
    protected $fillable = ['business_id','client_ref', 'division_ref', 'department_ref'];

      public function client(){
        return  $this->belongsTo('App\Models\client','client_ref','external_ref');
      }
    public function division(){
        return  $this->belongsTo('App\Models\division','division_ref','ref_code');
    }
    public function department(){
        return  $this->belongsTo('App\Models\department','department_ref','ref_code');
    }
}
