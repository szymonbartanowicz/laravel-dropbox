@extends('layouts.app')

@section('content')
    <div class="container">
        <nav class="nav">
        </nav>
        @if(\Illuminate\Support\Facades\Auth::user()->customer->access_token)
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('showCreateDir') }}">Create directory</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{ route('showUploadFile') }}">Upload file</a>
                    </li>
                </ol>
            </nav>
        @endif
        @if(!\Illuminate\Support\Facades\Auth::user()->customer->access_token)
            <div class="d-flex justify-content-center">
                <div class="mt-5">
                    <a href="/connect" class="btn btn-primary text-white">Connect your Dropbox account with
                        sbartanowicz-test1</a>
                </div>
            </div>
        @else
            @empty($files)
                <h3 class="ml-3">This folder is empty.</h3>
            @endempty
            <ul class="list-group w-50">
                @foreach($files as $file)
                    <li class="list-group-item">
                        @if($file['type'] === 'folder')
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-folder" fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.828 4a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 6.173 2H2.5a1 1 0 0 0-1 .981L1.546 4h-1L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3v1z"/>
                                <path fill-rule="evenodd"
                                      d="M13.81 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4zM2.19 3A2 2 0 0 0 .198 5.181l.637 7A2 2 0 0 0 2.826 14h10.348a2 2 0 0 0 1.991-1.819l.637-7A2 2 0 0 0 13.81 3H2.19z"/>
                            </svg>
                            <a href="{{ route('home', ['path' => $file['path'] . '/']) }}"
                               class="mx-1">{{ $file['name'] }}</a>
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right"
                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
                                <path fill-rule="evenodd"
                                      d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
                            </svg>
                            @if($file['root'] !== '/')
                                <form action="{{ route('deleteDir') }}" class="p-0 m-0 d-inline" method="POST">
                                    @csrf
                                    <input type="hidden" name="path" value="{{ $file['path'] }}">
                                    <button type="submit" class="btn btn-link float-right m-0 p-0">
                                        <a href="{{ route('deleteDir', ['path' => $file['path']]) }}" class="float-right ml-1">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash"
                                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd"
                                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </a>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('showUploadFile', ['path' => $file['path']]) }}" class="float-right ml-1">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-upload"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M.5 8a.5.5 0 0 1 .5.5V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5a.5.5 0 0 1 1 0V12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5A.5.5 0 0 1 .5 8zM5 4.854a.5.5 0 0 0 .707 0L8 2.56l2.293 2.293A.5.5 0 1 0 11 4.146L8.354 1.5a.5.5 0 0 0-.708 0L5 4.146a.5.5 0 0 0 0 .708z"/>
                                    <path fill-rule="evenodd"
                                          d="M8 2a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 8 2z"/>
                                </svg>
                            </a>
                            <a href="{{ route('showCreateDir', ['path' => $file['path']]) }}" class="float-right">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
                                    <path fill-rule="evenodd"
                                          d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
                                </svg>
                            </a>
                        @else
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-image"
                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                <path
                                    d="M10.648 7.646a.5.5 0 0 1 .577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71z"/>
                                <path fill-rule="evenodd" d="M4.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                            </svg>
                            <span class="mx-1">{{ $file['name'] }}</span>
                            <form action="{{ route('deleteFile') }}" class="p-0 m-0 d-inline" method="POST">
                                @csrf
                                <input type="hidden" name="path" value="{{ $file['path'] }}">
                                <button type="submit" class="btn btn-link float-right p-0 m-0">
                                    <a href="{{ route('deleteFile', ['path' => $file['path']]) }}" class="float-right ml-1">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash"
                                             fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd"
                                                  d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </a>
                                </button>
                            </form>

                            @if(in_array(last(explode('.', $file['name'])), ['jpg', 'jpeg', 'png', 'pdf']))
                                <a href="{{ route('download', ['path' => $file['path']]) }}" class="float-right">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download"
                                         fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M.5 8a.5.5 0 0 1 .5.5V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5a.5.5 0 0 1 1 0V12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5A.5.5 0 0 1 .5 8z"/>
                                        <path fill-rule="evenodd"
                                              d="M5 7.5a.5.5 0 0 1 .707 0L8 9.793 10.293 7.5a.5.5 0 1 1 .707.707l-2.646 2.647a.5.5 0 0 1-.708 0L5 8.207A.5.5 0 0 1 5 7.5z"/>
                                        <path fill-rule="evenodd"
                                              d="M8 1a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 8 1z"/>
                                    </svg>
                                </a>
                            @endif
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
