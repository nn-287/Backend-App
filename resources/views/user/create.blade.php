@extends('layouts.app')
 
@section('content')
    <h1 class="mb-0">Add user</h1>
    <hr />
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="first_name" class="form-control" placeholder="first_name">
            </div>
            <div class="col">
                <input type="text" name="second_name" class="form-control" placeholder="second_name">
            </div>

            <div class="col">
                <input type="text" name="password" class="form-control" placeholder="password">
            </div>

            <div class="col">
                <input type="text" name="email" class="form-control" placeholder="email">
            </div>

            <div class="col">
                <input type="text" name="phone_number" class="form-control" placeholder="phone_number">
            </div>

            <div class="col">
                <input type="text" name="profession" class="form-control" placeholder="profession">
            </div>

            <div class="col">
                <input type="text" name="gender" class="form-control" placeholder="gender">
            </div>
        </div>
        
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection