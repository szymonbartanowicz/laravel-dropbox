<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FileController extends Controller
{
    protected $service;

    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->index();
    }

    public function download()
    {
        return $this->service->download();
    }

    public function deleteFile(Request $request)
    {
        return $this->service->deleteFile($request->path);
    }

    public function deleteDir(Request $request)
    {
        return $this->service->deleteDir($request->path);
    }

    public function createDir(Request $request)
    {
        $request->validate([
            'path' => [
                'required',
                'max:255',
                Rule::unique('files', 'path')->where(function ($query) {
                    return $query->where('status', '<>', 'deleted');
                })
            ],
        ]);

        if ($request->path[0] !== '/') {
            return back()->withErrors('Path must start with /.');
        }

        return $this->service->createDir($request->path);
    }

    public function uploadFile(Request $request)
    {
        $messages = [
            'path.unique' => 'File with this name is already uploaded to this directory.',
        ];

        $request->validate([
            'path' => [
                'required',
                'max:255',
                Rule::unique('files', 'root')->where(function ($query) use ($request) {
                    return $query->where('status', '<>', 'deleted')
                        ->where('name', $request->file->getClientOriginalName());
                })
            ],
            'file' => [
                'required',
                'file',
                'max:1024',

            ]
        ], $messages);

        return $this->service->uploadFile($request->all());
    }
}
