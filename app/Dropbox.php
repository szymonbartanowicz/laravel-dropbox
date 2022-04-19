<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dropbox extends Model
{
    const APP_KEY = '';
    const APP_SECRET = '';
    const REDIRECT_URI = 'http://localhost:8000/setDbxCredentials';
}
