@extends('layout')


@section('content')

    <h1>All the Students</h1>

    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Surname</td>
            <th width="280px">Operation</th>
        </tr>
        </thead>
        <tbody>
        @foreach($students as $key => $value)
            <tr>
                <td>{{ $value->id }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->surname }}</td>

                <!-- we will also add show, edit, and delete buttons -->
                {{--{{ route('show',$value->id) }}--}}
                <td>
                    <a class="btn btn-info" href="{{ route('show',$value->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('edit',$value->id) }}">Edit</a>
                    <a class="btn btn-danger" href="{{ route('destroy',$value->id) }}">Delete</a>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $students->render() !!}
@endsection