<?php

namespace App\Http\Controllers;

use App\Events\DropboxApplicationModified;
use App\Services\WebhookService;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use League\Flysystem\Filesystem;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

class WebhookController extends Controller
{
    protected $service;

    public function __construct(WebhookService $service)
    {
        $this->service = $service;
    }

    public function init()
    {
        return $this->service->init();
    }

    public function process(Request $request)
    {
        return $this->service->process($request->list_folder['accounts']);
    }
}
