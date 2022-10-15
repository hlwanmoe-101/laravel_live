@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Create Category
                    </div>
                    <div class="card-body">
                        <form action="{{route('category.store')}}" method="post">
                            @csrf

                            <div class="row align-items-end">
                                <div class="col-6 col-lg-3">
                                    <label for="title">Category Title</label>
                                    <input type="text" name="title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror">
                                </div>
                                <div class="col-6 col-lg-3">
                                    <button class="btn btn-primary">Add Category</button>
                                </div>
                            </div>
                            @error('title')
                            <p class="small text-danger">{{$message}}</p>
                            @enderror
                        </form>

                        <table class="table table-hover table-bordered align-middle mt-2">
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
                                        <a href="{{route('category.edit',$category->id)}}">
                                            <button class="btn btn-sm btn-outline-warning">
                                                <i class="fa fa-pen-alt fa-fw"></i>
                                            </button>
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
                        <div class="text-center">
                            <a href="{{route('category.index')}}" class="btn btn-primary">Category Lists</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
