<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

            $posts=Post::when(isset(request()->search),function ($query){
                $search=request()->search;
                $query->where("title","LIKE","%$search%")->orwhere("description","LIKE","%$search%");
            })->latest('id')->paginate(5);



        return view('post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $request->validate([
            'title'=>'required|min:5|unique:posts,title',
            'category'=>'required|integer|exists:categories,id',
            'description'=>'required|min:20'
        ]);



        $post=new Post();
        $post->title=$request->title;
        $post->slug=Str::slug($request->title);
        $post->description=$request->description;
        $post->excerpt=Str::words($request->description,20);
        $post->category_id=$request->category;
        $post->user_id=Auth::id();
        $post->is_publish=true;
        $post->save();

        return redirect()->route('post.index')->with("status","Create Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit',compact("post"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $request->validate([
            'title'=>"required|min:5|unique:posts,title,$post->id",
            'category'=>'required|integer|exists:categories,id',
            'description'=>'required|min:20'
        ]);
        $post->title=$request->title;
        $post->slug=Str::slug($request->title);
        $post->description=$request->description;
        $post->excerpt=Str::words($request->description,20);
        $post->category_id=$request->category;
        $post->update();
        return redirect()->route('post.index')->with("status","Update Successfully");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->with("status","Delete Successfully");
    }
}
