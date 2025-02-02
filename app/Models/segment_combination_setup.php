<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class segment_combination_setup extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'segment_combination_setups';

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
    protected $fillable = ['seg_comb_code', 'structure_code',   'default_allocated_user', 'status'];


    public function  segment_combination_user(){
        return $this->hasMany('App\Models\segment_combination_user' ,  'seg_combination_setup_id' );
    }



    ///////////////////////////////////////////////////////////////////
    public function  clients(){
        return $this->hasMany('App\Models\segment_combination_setup_value', 'seg_combination_setup_id'  );
    }


    public function  segment_details(){
        return $this->belongsTo('App\Models\segment_head_detail' , 'segment_value_id'   );
    }




}
