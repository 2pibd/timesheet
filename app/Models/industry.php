<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class industry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'industries';

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
    protected $fillable = [ 'industry', 'slug', 'status', 'sort_order'  ];

    public function sectors(){
        return $this->hasMany('App\Models\industry_sub_sector',  'industry_id' );
    }
}
