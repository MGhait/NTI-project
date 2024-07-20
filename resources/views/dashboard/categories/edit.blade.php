@extends('dashboard/layout')

@section('contents')
    <h2>
        Edit Category
    </h2>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('categories.index') }}"> Back</a>
        </div>


    <h3>
        <form id="CreateForm" action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Category Name:</strong>
                        <input type="text" name="name" class="form-control" placeholder="categoryName" value="{{ $category->name }}">
                    </div>
                    @error('name')
                    <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Category Description:</strong>
                        <textarea name="description" class="form-control"> {{ $category->description }}</textarea>
{{--                        <input type="text" name="name" class="form-control" placeholder="categoryName" value="{{ $category->name }}">--}}
                    </div>
                    @error('description')
                    <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-check form-switch">
                        @php
                            if($category->isActive == 1) {
                                $status = "checked";
                            }
                            else {
                                $status = "";
                            }
                        @endphp
                        <input type="checkbox" class="form-check-input" name="isShown" {{$category->isActive == 1 ? "checked" : ""}}>
                        <label class="form-check-label" for="isShown">
                            is Active Category
                        </label>
                    </div>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>

        </form>
    </h3>
@endsection

