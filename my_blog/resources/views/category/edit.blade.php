@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Edit Category
                    </div>
                    <div class="card-body">
                        <form action="{{route('category.update',$category->id)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="row align-items-end">
                                <div class="col-6 col-lg-3">
                                    <label for="title">Category Title</label>
                                    <input type="text" name="title" value="{{old('title',$category->title)}}" class="form-control @error('title') is-invalid @enderror">
                                </div>
                                <div class="col-6 col-lg-3">
                                    <button class="btn btn-primary">Update Category</button>
                                </div>
                            </div>
                            @error('title')
                            <p class="small text-danger">{{$message}}</p>
                            @enderror
                        </form>
                        <div class="mt-2">
                            <a href="{{route('category.index')}}" class="btn btn-primary">Category Lists</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
