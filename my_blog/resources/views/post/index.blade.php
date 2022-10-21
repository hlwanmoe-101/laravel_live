@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Post Lists
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <a href="{{route('post.create')}}" class="btn btn-primary">Create Post</a>
                                @isset(request()->search)
                                    <a href="{{route('post.index')}}" class="btn btn-outline-primary">
                                        All Post
                                    </a>
                                    <span class="h5">Search by: "{{request()->search}}"</span>
                                    @endisset
                            </div>
                            <form method="get">
                                <div class="input-group">
                                    <input type="text" name="search" value="{{request()->search}}" class="form-control" placeholder="Search">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="fas fa-search fa-fw"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
{{--                        @if(session("status"))--}}
{{--                            <p class="alert alert-success">{{session("status")}}</p>--}}
{{--                        @endif--}}
                        <table class="table table-hover align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Photo</th>
                                <th>Owner</th>
                                <th>Is Publish</th>
                                <th>Category</th>
{{--                                <th>Description</th>--}}
                                <th>Control</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td>{{$post->id}}</td>
                                    <td class="small w-25">{{Str::words($post->title,10)}}</td>
                                    <td>
                                        @forelse($post->photos()->latest('id')->limit(3)->get() as $photo)
                                            <a class="venobox" data-gall="img{{$post->id}}" href="{{asset('storage/photo/'.$photo->name)}}">
                                                <img src="{{asset('storage/thumbnail/'.$photo->name)}}" class="rounded-circle border border-white shadow-sm list-thumbnail" height="30" alt="">
                                            </a>
                                            @empty
                                            No Photo
                                        @endforelse
                                    </td>
                                    <td>
                                        {{$post->user->name}}
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" {{ $post->is_publish ? "checked" : "" }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault">
                                                {{$post->is_publish ? "Publish" : "Unpublish"}}
                                            </label>

                                        </div>
                                    </td>
                                    <td>
                                        {{$post->category->title}}
                                    </td>
{{--                                    <td class="small">--}}
{{--                                        {{\Illuminate\Support\Str::words($post->description,20)}}--}}
{{--                                    </td>--}}
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('post.show',$post->id)}}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-primary" form="post-delete{{$post->id}}">
                                                <i class="fa fa-trash-alt fa-fw"></i>
                                            </button>
                                            <a href="{{route('post.edit',$post->id)}}" class="btn btn-sm btn-outline-primary">
                                               <i class="fa fa-pen-alt fa-fw"></i>
                                            </a>
                                        </div>
                                        <form action="{{route('post.destroy',$post->id)}}" id="post-delete{{$post->id}}" class="d-inline-block" method="post">
                                            @csrf
                                            @method('delete')

                                        </form>
                                    </td>
                                    <td>
                                        <i class="fa fa-calendar"></i>
                                        <small>{{$post->created_at->format("d-m-Y")}}</small>
                                        <br>
                                        <i class="fa fa-clock-four"></i>
                                        <small>{{$post->created_at->format("h:m A")}}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center"> There is no data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between">
                            {{$posts->appends(request()->all())->links()}}
                            <p class="h4 font-weight-bold">Total : {{ $posts->total() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
