<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class segment_structure_info extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'segment_structure_infos';

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
    protected $fillable = ['order_by', 'structure_code', 'seg_head_id', 'status'];


    public function  segments(){
        return $this->belongsTo('App\Models\segment_head' , 'seg_head_id'  );
    }


    public function  structure(){
        return $this->hasMany('App\Models\segment_structure_info' , 'structure_code','structure_code'  );
    }
}
