@extends('layout')
@section('content')
    @if(isset($student))
        <h2>Search Result</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>SDR</th>
                <th>First Name</th>
            </tr>
            </thead>
            <tbody>
            @foreach($student as $data)
                <tr>
                    <td>{{$data->sdr}}</td>
                    <td>{{$data->first_name}}</td>
                    <td>
                        <a class="btn btn-info" href="{{ route('show',$data->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('edit',$data->id) }}">Edit</a>
                        <a class="btn btn-danger" href="{{ route('destroy',$data->id) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div style="padding-top: 20px;">
            <p> {{$message}}</p>
        </div>
    @endif
@endsection