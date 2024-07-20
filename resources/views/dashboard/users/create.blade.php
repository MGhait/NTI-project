@extends('dashboard/layout')
{{--@section('title','Create New Category')--}}


@section('contents')
    <h3>
        <form id="CreateForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12"
                     style="margin-bottom: 10px">
                    <div class="form-group">
                        <strong class="form-control" style="color: #0d6efd" >User Full Name</strong>
                        <input type="text" name="fullName" class="form-control" placeholder="User Full Name">
                    </div>
                    @error('fullName')
                    <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12"
                     style="margin-bottom: 10px">
                    <div class="form-group">
                        <strong class="form-control" style="color: #0d6efd" >User Login Name</strong>
                        <input type="text" name="logName" class="form-control" placeholder="User Login Name">
                    </div>
                    @error('logName')
                    <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12"
                     style="margin-bottom: 10px">
                    <div class="form-group">
                        <strong class="form-control" style="color: #0d6efd" >Password</strong>
                        <input type="text" name="password" class="form-control" placeholder="Your Password Here">
                    </div>
                    @error('password')
                    <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <div class="form-group">
                    <strong class="form-control" style="color: #0d6efd" >User Role</strong>
                    <select class="form-control" style="color: #47ea70" name="role">
                        @foreach($roleOptions as $role)
                            @if($role!= 'admin')
                            <option class="form-select" value="{{$role}}">
                                {{ucfirst($role)}}
                            </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>

        </form>
    </h3>
@endsection


