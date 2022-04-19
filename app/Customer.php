<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['user_id', 'dbx_id', 'access_token', 'cursor'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function files()
    {
        return $this->hasMany('App\File')->where('status', '<>', 'deleted');
    }
}
