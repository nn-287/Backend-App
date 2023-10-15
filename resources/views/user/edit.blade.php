@extends('layouts.app')
 
@section('content')
    <h1 class="mb-0">Edit user</h1>
    <hr />
    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">first name</label>
                <input type="text" name="first_name" class="form-control" placeholder="first_name" value="{{ $user->first_name }}" >
            </div>


            <div class="col mb-3">
                <label class="form-label">second name</label>
                <input type="text" name="second_name" class="form-control" placeholder="second_name" value="{{ $user->second_name }}" >
            </div>
           
            <div class="col mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" placeholder="email" value="{{ $user->email }}" >
            </div>

            <div class="col mb-3">
                <label class="form-label">phone number</label>
                <input type="text" name="phone_number" class="form-control" placeholder="phone_number" value="{{ $user->phone_number }}" >
            </div>

            <div class="col mb-3">
                <label class="form-label">Profession</label>
                <input type="text" name="profession" class="form-control" placeholder="profession" value="{{ $user->profession }}" >
            </div>

            <div class="col mb-3">
                <label class="form-label">Gender</label>
                <input type="text" name="gender" class="form-control" placeholder="gender" value="{{ $user->gender }}" >
            </div>
        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>
@endsection