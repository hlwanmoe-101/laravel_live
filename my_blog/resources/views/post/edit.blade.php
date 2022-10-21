@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        Edit Post
                    </div>
                    <div class="card-body">
                        <form action="{{route('post.update',$post->id)}}" id="postUpdateForm" method="post">
                            @csrf
                            @method('put')
                        </form>
                            <div class="mb-3">
                                <label for="title">Post Title</label>
                                <input type="text" name="title" value="{{old('title',$post->title)}}" form="postUpdateForm" class="form-control @error('title') is-invalid @enderror">
                                @error('title')
                                <p class="small text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select name="category" form="postUpdateForm" class="form-select @error('category') is-invalid @enderror">
                                    @foreach(\App\Models\Category::all() as $categories)
                                        <option value="{{$categories->id}}"  {{ $categories->id == old('category',$post->category_id) ? 'selected': ''}}>{{$categories->title}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <p class="small text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="photo">Photo</label>
                                <div class="border rounded p-3 d-flex overflow-scroll">
                                    <form action="{{route('photo.store')}}" class="d-none" id="photoUploadForm" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$post->id}}" name="postId">
                                        <label for="photo">Photo Upload</label>
                                        <input type="file" name="photo[]" multiple value="{{old("photo")}}" id="photoInput" class="form-control @error('photo') is-invalid @enderror">
                                        <button class="btn btn-primary btn-sm">Upload</button>
                                        @error('photo')
                                        <p class="small text-danger">{{$message}}</p>
                                        @enderror
                                    </form>
                                    <div class="border border-2 rounded-3 me-1 uploaderUi d-flex justify-content-center align-items-center" id="photoUploadUi">
                                        <i class="fas fa-plus fa-3x text-muted"></i>
                                    </div>
                                    @forelse($post->photos as $photo)
                                        <div class="position-relative">
                                            <form action="{{route('photo.destroy',$photo->id)}}" class="position-absolute bottom-0 start-0" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            <img src="{{asset('storage/thumbnail/'.$photo->name)}}" class="rounded-3 me-1" height="100" alt="">
                                        </div>

                                    @empty
                                        No Photo
                                    @endforelse
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="title">Description</label>
                                <textarea type="text" rows="10" form="postUpdateForm" name="description" class="form-control @error('description') is-invalid @enderror">{{old('description',$post->description)}}</textarea>
                                @error('description')
                                <p class="small text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" required>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Sure</label>
                                </div>
                                <button class="btn btn-lg btn-primary" form="postUpdateForm">Update</button>
                            </div>







                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        let photoUploadForm=document.getElementById("photoUploadForm");
        let photoInput=document.getElementById("photoInput");
        let photoUploadUi=document.getElementById("photoUploadUi");

        photoUploadUi.addEventListener("click",function () {
          photoInput.click();
        })
        photoInput.addEventListener("change",function () {
            photoUploadForm.submit();
        })



    </script>

@endsection
