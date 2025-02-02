<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class online_message_to_users extends Model
{
    protected $table = 'online_message_to_users';

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
    protected $fillable = ['online_message_id', 'user_type', 'user_id'];

    public function online_message()
    {
        return $this->belongsTo('App\Models\online_message' ,  'online_message_id' );
    }
}
