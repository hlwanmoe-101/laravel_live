@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        My Photos
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            @forelse(auth()->user()->photos as $photo)
                                <div class="position-relative me-1">
                                    <form action="{{route('photo.destroy',$photo->id)}}" class="position-absolute bottom-0 start-0" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <a class="venobox" data-gall="img}}" href="{{asset('storage/photo/'.$photo->name)}}">
                                        <img src="{{asset('storage/thumbnail/'.$photo->name)}}" class="rounded-3" height="150" alt="">
                                    </a>
                                </div>
                            @empty
                                No Photo
                            @endforelse
                        </div>
                        {{$categories}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
