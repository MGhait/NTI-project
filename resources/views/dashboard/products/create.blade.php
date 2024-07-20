@extends('dashboard/layout')



@section('contents')
    <h2>
        Create New Product
    </h2>
    <div class="pull-right">
        <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
    </div>

    <h3>
        <form id="CreateForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Product Name</strong>
                        <input type="text" name="name" class="form-control" placeholder="Project Title">
                    </div>
                    @error('name')
                        <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Product Description</strong>
                        <input type="text" class="form-control" name="description" placeholder="Project Brief">
                    </div>
                    @error('description')
                        <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Product Price</strong>
                        <input type="number" step="0.1" class="form-control" name="price" placeholder="Project Price">
                    </div>
                    @error('price')
                    <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Product Photo:</strong>
                        <input type="file" class="form-control" name="photo" placeholder="Team Member Photo" onchange=" imageFilePreview (this);">
                    </div>
                    @error('photo')
                    <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <img id="imagePreview" alt="image Preview" style="max-width:150px; max-height:150px;">

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Project Category</strong>
                        <select class="form-select mb-3" name="category_id">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}"> {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('category_id')
                        <h5 class="alert alert-danger">{{ $message }}</h5>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>

        </form>
    </h3>
@endsection
<script>
    function imageFilePreview(inputFile){
        var file = inputFile.files[0];
        if(file){
            var reader = new FileReader();
            reader.onload = function(){
                document.getElementById("imagePreview").setAttribute("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
</script>


