@extends('dashboard/layout')

@section('contents')
{{--    <h2>--}}
{{--        Edit User--}}
{{--    </h2>--}}
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>


    <h3>
        <form id="CreateForm" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12"
                style="margin-bottom: 10px">
                    <div class="form-group">
                        <strong class="form-control" style="color: #0d6efd" >User Full Name</strong>
                        <input type="text" name="fullName" class="form-control" value="{{ $user->fullName }}">
                    </div>
                    @error('fullName')
                    <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12"
                     style="margin-bottom: 10px">
                    <div class="form-group">
                        <strong class="form-control" style="color: #0d6efd" >User Log Name</strong>
{{--                        <textarea name="description" class="form-control"> {{ $user->description }}</textarea>--}}
                        <input type="text" name="logName" class="form-control" value="{{ $user->logName }}">
                    </div>
                    @error('logName')
                    <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12"
                     style="margin-bottom: 10px">
                    <div class="form-group">
                        <strong class="form-control" style="color: #0d6efd" >User Role</strong>
{{-- --------------------------------(there is more thean way to do it)----------------------------}}
{{--                        first one is select second one is radion but we need it to be select and option here --}}
                        <select class="form-control" style="color: #47ea70" name="role">
                            @foreach($roleOptions as $role)
                            <option class="form-select" value="{{$role}}">
                                {{ucfirst($role)}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @error('role')
                    <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-check form-switch">
                        @php
                            if($user->isActive == 1) {
                                $status = "checked";
                            }
                            else {
                                $status = "";
                            }
                        @endphp
                        <input type="checkbox" class="form-check-input" name="isActive" {{$user->isActive == 1 ? "checked" : ""}}>
                        <label class="form-check-label" for="isActive">
                            is Active User
                        </label>
                    </div>
{{--                     pass here --}}

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>

        </form>
    </h3>
@endsection

