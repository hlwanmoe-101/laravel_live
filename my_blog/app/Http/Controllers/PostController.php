<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Info;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//            $posts=Post::when(isset(request()->search),function ($query){
//                $search=request()->search;
//                $query->where("title","LIKE","%$search%")->orwhere("description","LIKE","%$search%");
//            })->latest('id')->paginate(5);
        $posts=Post::search()->latest('id')->paginate(5);



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
//        Gate::authorize('create',$request->post);
//        $request->validate([
//            'title'=>'required|min:5|unique:posts,title',
//            'category'=>'required|integer|exists:categories,id',
//            'description'=>'required|min:20',
//            'photos'=>'required',
//            'photos.*'=>'file|max:3000|mimes:jpg,png,jpeg',
//            'tags'=>'required',
//            'tags.*'=>'integer|exists:tags,id'
//        ]);

//        DB::transaction(function () use($request){

        DB::beginTransaction();
        try{
            $post=new Post();
            $post->title=$request->title;
//        $post->slug=Str::slug($request->title);
            $post->slug=$request->title;
            $post->description=$request->description;
            $post->excerpt=$request->description;
            $post->category_id=$request->category;
            $post->user_id=Auth::id();
            $post->is_publish=true;
            $post->save();

            //auto make folder
            if(!Storage::directories("public/thumbnail")){
                Storage::makeDirectory("public/thumbnail");
            }

            Info::savePhoto($post->id);

//            if($request->hasFile('photos')){
//                foreach ($request->file('photos') as $photo){
//                    //save in storage
//                    $newName=uniqid()."_photo.".$photo->extension();
//                    $photo->storeAs("public/photo/",$newName);
//                    //reduce size
//                    $img=Image::make($photo);
//                    $img->fit(200,200);
//                    $img->save("storage/thumbnail/".$newName);
//
//                    //save in db
//                    $photo=new Photo();
//                    $photo->name=$newName;
//                    $photo->post_id=$post->id;
//                    $photo->user_id=Auth::id();
//                    $photo->save();
//                }
//
//            }
            //tags save many to may
            $post->tags()->attach($request->tags);

            DB::commit();

        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }

//        });

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
//        if(Gate::allows('update_post',$post)){
//            return view('post.edit',compact("post"));
//        }else{
//            return abort('403');
//        }

//        if(Gate::denies('update_post',$post)){
//            return abort('403');
//        }
//        return view('post.edit',compact("post"));

//        Gate::authorize('update_post',$post);
//        return view('post.edit',compact("post"));

        Gate::authorize('update',$post);
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
//        Gate::authorize('update',$post);
//        $request->validate([
//            'title'=>"required|min:5|unique:posts,title,$post->id",
//            'category'=>'required|integer|exists:categories,id',
//            'description'=>'required|min:20',
//            'tags'=>'required',
//            'tags.*'=>'integer|exists:tags,id'
//        ]);
        $post->title=$request->title;
        $post->slug=Str::slug($request->title);
        $post->description=$request->description;
        $post->excerpt=Str::words($request->description,20);
        $post->category_id=$request->category;
        $post->update();
        //tags update
//        return $post->tags;
        $post->tags()->detach();
        $post->tags()->attach($request->tags);
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
        Gate::authorize('delete',$post);

        foreach ($post->photos as $photo){
            //file delete
            Storage::delete('public/photo/'.$photo->name);
            Storage::delete('public/thumbnail/'.$photo->name);
        }
        //db record delete hasmany
        $post->photos()->delete();
        //tags from pivot
        $post->tags()->detach();
        $post->delete();
        return redirect()->back()->with("status","Delete Successfully");
    }
}
