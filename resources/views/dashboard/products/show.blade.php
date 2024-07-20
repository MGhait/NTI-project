@extends('dashboard.layout')

@section('contents')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Show Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <h2 class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Project Name : </strong>
                {{ $product->name }}
            </div>
            <div class="form-group">
                <strong>Project Description : </strong>
                {{ $product->description }}
            </div>
            <div class="form-group">
                <strong>Project Category : </strong>
                {{ $product->category->name }}
            </div>
            <div class="form-group">
                <strong>Project Price : </strong>
                {{ $product->price }}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                @php
                    $photo = asset("images/" . $product->photo);
                @endphp
                <img src="{{ $photo }}" width="300" alt="">
            </div>
            @if(\App\Policycheck::pv('supervisor'))
                <a class="btn btn-info m-5" href="{{ route('products.publish', $product->id) }}">publish</a>
            @endif

        </h2>

    </div>

@endsection
