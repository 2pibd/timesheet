<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class segment_head_detail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'segment_head_details';

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
    protected $fillable = ['seg_head_id', 'seg_code', 'details', 'status','default_currency','country','address1','address2','address3','address4','address5','city','state','postcode'];
//segment_head
    public function  segment_head(){
        return $this->belongsTo('App\Models\segment_head' , 'seg_head_id'  );
    }
    public function  hasvalues(){
        return $this->hasMany('App\Models\segment_combination_setup_value' , 'segment_value_id'  );
    }
}
