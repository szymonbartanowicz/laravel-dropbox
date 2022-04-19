@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Create directory</h3>
        <form action="/createDir" method="post">
            @csrf
            <div class="form-group">
                <label>Directory name</label>
                <input type="text" name="path" value="{{ request('path') ? request('path') : '/' }}" class="form-control"
                       placeholder="Enter directory name">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        @if ($errors->any())
            <div class="mt-3">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
