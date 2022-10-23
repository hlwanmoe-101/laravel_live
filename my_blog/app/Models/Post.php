<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $with=['user','photos','category','tags'];

    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function photos(){
        return $this->hasMany(Photo::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

//    public function getTitleAttribute($value){
//        return Str::words($value,10);
//    }

//   accessor
    public function getShortTitleAttribute(){
        return Str::words($this->title,10);
    }

    public function getShowTimeAttribute(){
        return "<i class='fa fa-calendar'></i>
                <small>".$this->created_at->format('d-m-Y')."</small>
                <br>
                <i class='fa fa-clock-four'></i>
                <small>".$this->created_at->format('h:m A')."</small>";
    }

    //mutator
    public function setSlugAttribute($value){
        $this->attributes['slug']=Str::slug($value);
    }
    public function setExcerptAttribute($value){
        $this->attributes['excerpt']=Str::words($value,20);
    }

    //event

//    protected static function booted()
//    {
//        static::created(function (){
//            logger("hello");
//        });
//    }

        public function scopeSearch($query){
            $search=request()->search;
            return $query->where("title","LIKE","%$search%")->orwhere("description","LIKE","%$search%");
        }
}

