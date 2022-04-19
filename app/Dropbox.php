<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dropbox extends Model
{
    const APP_KEY = 'h82u3wzjz8fkwnx';
    const APP_SECRET = 'ga8am5xcdq4jn14';
    const REDIRECT_URI = 'http://localhost:8000/setDbxCredentials';
}
