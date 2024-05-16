@extends('include.default')
@section('title',"Update Page")
@section('content')
    @include("include.header")
    <div class="container mt-5">
        @if($errors->any())
            <div class="col-6">
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{route("product.update", ['product' => $product])}}">
            @csrf
            @method("put")
            <div class="row justify-content-start">
                <div class="col-md-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{$product->title}}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Price</label>
                    <input type="text" name="price" class="form-control" value="{{$product->price}}">
                </div>
            </div>
            <div class="row justify-content-start mt-3">
                <div class="col-md-6">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" class="form-control" value="{{$product->description}}">
                </div>
            </div>
            <button class="btn btn-success mt-2" type="submit">Update</button>
        </form>
    </div>
@endsection


