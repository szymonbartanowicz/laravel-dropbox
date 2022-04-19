<?php


namespace App\Services;


use Illuminate\Support\Facades\Auth;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

class FileService
{

    public function index()
    {
        $path = request('path') ? request('path') : NULL;

        if (!$path) {
            $files = Auth::user()->customer->files()
                ->where('root', '/')
                ->get();
        } else {
            $files = Auth::user()->customer->files()
                ->where('root', $path)
                ->get();
        }

        return view('home', ['files' => $files->toArray()]);
    }

    public function download()
    {
        $path = request('path');

        $client = new Client(Auth::user()->customer->access_token);
        $adapter = new DropboxAdapter($client);
        $link = $adapter->getTemporaryLink($path);

        return redirect($link);
    }

    public function deleteDir($path)
    {
        $path = request('path');

        $client = new Client(Auth::user()->customer->access_token);
        $adapter = new DropboxAdapter($client);
        $filesystem = new Filesystem($adapter, ['case_sensitive' => false]);

        $filesystem->deleteDir($path);

        return redirect()->route('home');
    }

    public function deleteFile($path)
    {
        $client = new Client(Auth::user()->customer->access_token);
        $adapter = new DropboxAdapter($client);
        $filesystem = new Filesystem($adapter, ['case_sensitive' => false]);

        $filesystem->delete($path);

        return redirect()->route('home');
    }

    public function createDir($dirName)
    {
        $client = new Client(Auth::user()->customer->access_token);
        $adapter = new DropboxAdapter($client);
        $filesystem = new Filesystem($adapter, ['case_sensitive' => false]);

        $filesystem->createDir($dirName);

        return redirect()->route('home');
    }

    public function uploadFile($data)
    {
        $file = $data['file'];
        $name = $file->getClientOriginalName();
        $file = fopen($file, 'r');

        $client = new Client(Auth::user()->customer->access_token);
        $adapter = new DropboxAdapter($client);
        $filesystem = new Filesystem($adapter, ['case_sensitive' => false]);

        $filesystem->write($data['path'] . '/' . $name, $file);

        return redirect()->route('home');
    }
}
