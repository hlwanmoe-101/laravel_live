@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Crategory Lists
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <a href="{{route('category.create')}}" class="btn btn-primary">Create Category</a>
                        </div>
                        @if(session("status"))
                            <p class="alert alert-success">{{session("status")}}</p>
                            @endif
                        <table class="table table-hover table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Owner</th>
                                    <th>Control</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                        <tr>
                                            <td>{{$category->id}}</td>
                                            <td>{{$category->title}}</td>
                                            <td>
                                                {{$category->user->name}}
                                            </td>
                                            <td>
                                                <form action="{{route('category.destroy',$category->id)}}" class="d-inline-block" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-outline-danger">
                                                        <i class="fa fa-trash-alt fa-fw"></i>
                                                    </button>
                                                </form>
                                                <a href="{{route('category.edit',$category->id)}}" class="btn btn-sm btn-outline-warning">
                                                       <i class="fa fa-pen-alt fa-fw"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <i class="fa fa-calendar"></i>
                                                <small>{{$category->created_at->format("d-m-Y")}}</small>
                                                <br>
                                                <i class="fa fa-clock-four"></i>
                                                <small>{{$category->created_at->format("h:m A")}}</small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center"> There is no data</td>
                                        </tr>
                                    @endforelse
                            </tbody>
                        </table>
                        {{$categories->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
