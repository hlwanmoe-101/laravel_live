@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        Create Post
                    </div>
                    <div class="card-body">
                        <form action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
                            @csrf


                                <div class="mb-3">
                                    <label for="title">Post Title</label>
                                    <input type="text" name="title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror">
                                    @error('title')
                                     <p class="small text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" class="form-select @error('category') is-invalid @enderror">
                                        @foreach(\App\Models\Category::all() as $categories)
                                            <option value="{{$categories->id}}"  {{ $categories->id == old('category') ? 'selected': ''}}>{{$categories->title}}</option>
                                            @endforeach
                                    </select>
                                    @error('category')
                                     <p class="small text-danger">{{$message}}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="">Tags</label>
                                    <br>
                                    @foreach(\App\Models\Tag::all() as $tag)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" value="{{$tag->id}}" name="tags[]" id="flexCheckDefault{{$tag->id}}" {{ in_array($tag->id,old('tags',[]))? 'checked': '' }}>
                                            <label class="form-check-label" for="flexCheckDefault{{$tag->id}}">
                                                {{$tag->title}}
                                            </label>
                                        </div>
                                        @endforeach
                                    @error('tags')
                                    <p class="small text-danger">{{$message}}</p>
                                    @enderror
                                    @error('tags.*')
                                    <p class="small text-danger">{{$message}}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="photos">Photo Upload</label>
                                    <input type="file" name="photos[]" multiple value="{{old("photos")}}" class="form-control @error('photo') is-invalid @enderror">
                                    @error('photos')
                                    <p class="small text-danger">{{$message}}</p>
                                    @enderror
                                    @error('photos.*')
                                    <p class="small text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="title">Description</label>
                                    <textarea type="text" rows="10" name="description" class="form-control @error('description') is-invalid @enderror">{{old('description')}}</textarea>
                                    @error('description')
                                     <p class="small text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" required>
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Sure</label>
                                    </div>
                                    <button class="btn btn-lg btn-primary">Add Post</button>
                                </div>


                        </form>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
{{--                        <div class="text-center">--}}
{{--                            <a href="{{route('category.index')}}" class="btn btn-primary">Category Lists</a>--}}
{{--                        </div>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
