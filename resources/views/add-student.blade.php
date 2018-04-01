@extends('layout')


@section('content')

    @if ( Session::has('success') )
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>{{ Session::get('success') }}</strong>
        </div>
    @endif

    @if ( Session::has('error') )
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>{{ Session::get('error') }}</strong>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        Choose your xls/csv File : <input type="file" name="file" class="form-control">

        <input type="submit" class="btn btn-primary btn-lg" style="margin-top: 3%">
    </form>
@endsection