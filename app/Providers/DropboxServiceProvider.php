<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;

class DropboxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('dropbox', function ($app, $config) {
            $client = new DropboxClient(
//                $config['authorization_token']
            '6Im-Ot8gY1MAAAAAAAAAAR-8lYjipA1vUFit91Le7QmA4-8fgMdPA3WR7JqBpo1e'
            );

            return new Filesystem(new DropboxAdapter($client));
        });
    }
}
