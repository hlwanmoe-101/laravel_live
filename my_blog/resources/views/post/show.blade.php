@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class=""></i>{{$post->title}}</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="me-3 text-muted">
                                <i class="fas fa-user text-primary"></i>
                                {{$post->user->name}}
                            </div>
                            <div class="text-muted">
                                <i class="fas fa-calendar-alt text-primary"></i>
                                {{$post->created_at->format("d-m-Y | h:i A")}}
                            </div>
                        </div>

                        <div class="mb-3">
                            {{$post->description}}
                        </div>


                        @forelse($post->photos as $photo)

                            <a class="venobox" data-gall="img{{$post->id}}" href="{{asset('storage/photo/'.$photo->name)}}">
                                <img src="{{asset('storage/thumbnail/'.$photo->name)}}" class="rounded-3" height="150" alt="">
                            </a>

                        @empty

                        @endforelse

                        <hr>
                        <a href="{{route('post.index')}}" class="btn btn-outline-primary">
                            All Post
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
