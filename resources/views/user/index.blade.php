@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">List Users</h1>
        <a href="{{ route('user.create') }}" class="btn btn-primary">Add User</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>first_name</th>
                <th>second_name</th>
                <th>email</th>
                <th>email_verified_at</th>
                <th>phone_number</th>
                <th>profession</th>
                <th>gender</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($users->count() > 0)
                @foreach($users as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->first_name }}</td>
                        <td class="align-middle">{{ $rs->second_name }}</td>
                        <td class="align-middle">{{ $rs->email }}</td>
                        <td class="align-middle">{{ $rs->email_verified_at }}</td>
                        <td class="align-middle">{{ $rs->phone_number }}</td>
                        <td class="align-middle">{{ $rs->profession }}</td>
                        <td class="align-middle">{{ $rs->gender }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                
                                <a href="{{ route('user.edit', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
                                <form action="{{ route('user.destroy', $rs->id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Product not found</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection
