@extends('dashboard/layout')

@section('title','Create New Category')

@section('contents')


    <h3>
        <form id="CreateForm" action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Category Name:</strong>
                        <input type="text" name="name" class="form-control" placeholder="categoryName">
                    </div>
                    @error('name')
                    <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Category Description:</strong>
                        <textarea name="description" class="form-control" placeholder="category description"></textarea>
                    </div>
                    @error('description')
                    <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" name="isActive">
                        is Active category

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


