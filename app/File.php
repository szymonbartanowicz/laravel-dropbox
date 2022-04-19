<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['customer_id', 'dbx_id', 'name', 'root', 'path', 'size','last_modified', 'type', 'status'];
}
