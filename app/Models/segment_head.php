<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class segment_head extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'segment_heads';

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
    protected $fillable = ['seg_name', 'min_length', 'max_length', 'status'];


    public function  segment_details(){
        return $this->hasMany('App\Models\segment_head_detail' , 'seg_head_id'   );
    }
}
