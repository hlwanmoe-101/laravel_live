@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{$post->title}}
                    </div>
                    <div class="card-body">
                        <div>
                            <i class="fas fa-user"></i>
                            {{$post->user->name}}
                        </div>
                        {{$post->description}}
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
