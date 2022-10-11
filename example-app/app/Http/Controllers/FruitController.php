<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFruitRequest;
use App\Http\Requests\UpdateFruitRequest;
use App\Models\Fruit;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class FruitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFruitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFruitRequest $request)
    {
        $validator=Validator::make($request->all(),[
            "name"=>"required|min:3",
            "price"=>"required|integer|min:100",
            "photo"=>"required|file|max:3000|mimes:jpg,png,jpeg"
        ]);

        if($validator->fails()){
            return response()->json([
                "status"=>"fail",
                "error"=> $validator->errors()
            ]);
        }

        $photo=$request->file('photo');
        $newName=uniqid()."_photo.".$photo->extension();
        $photo->StoreAs("public/photo",$newName);
        $img=Image::make($photo);
        $img->fit(300,300)->save("storage/thumbnail/".$newName,80);

        $fruit=new Fruit();
        $fruit->name=$request->name;
        $fruit->price=$request->price;
        $fruit->photo=$newName;
        $fruit->save();

        $fruit->original_photo=asset('storage/photo/'.$fruit->photo);
        $fruit->thumbnail_photo=asset('storage/thumbnail/'.$fruit->photo);
        $fruit->time=$fruit->created_at->diffForHumans();
        return response()->json([
            "status"=>"success",
            "info"=> $fruit
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fruit  $fruit
     * @return \Illuminate\Http\Response
     */
    public function show(Fruit $fruit)
    {
        $fruit->original_photo=asset('storage/photo/'.$fruit->photo);
        $fruit->thumbnail_photo=asset('storage/thumbnail/'.$fruit->photo);
        $fruit->time=$fruit->created_at->diffForHumans();
        return $fruit;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fruit  $fruit
     * @return \Illuminate\Http\Response
     */
    public function edit(Fruit $fruit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFruitRequest  $request
     * @param  \App\Models\Fruit  $fruit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFruitRequest $request, Fruit $fruit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fruit  $fruit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fruit $fruit)
    {
        //
    }
}
