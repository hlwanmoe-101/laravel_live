<?php

namespace App;

use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class Info
{


    public static function savePhoto($postId){
        if(request()->hasFile('photos')){
            foreach (request()->file('photos') as $photo){
                //save in storage
                $newName=uniqid()."_photo.".$photo->extension();
                $photo->storeAs("public/photo/",$newName);
                //reduce size
                $img=Image::make($photo);
                $img->fit(200,200);
                $img->save("storage/thumbnail/".$newName);

                //save in db
                $photo=new Photo();
                $photo->name=$newName;
                $photo->post_id=$postId;
                $photo->user_id=Auth::id();
                $photo->save();
            }

        }
    }



}
