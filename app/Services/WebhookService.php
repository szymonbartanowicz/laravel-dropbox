<?php


namespace App\Services;

use App\Events\DropboxApplicationModified;
use Illuminate\Support\Facades\Auth;

class WebhookService
{
    public function init()
    {
        return request()->get('challenge');
    }

    public function process($ids)
    {
        return event(new DropboxApplicationModified($ids));
    }
}
