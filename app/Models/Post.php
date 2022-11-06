<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;


class Post extends Model implements TranslatableContract
{
    use HasFactory , Translatable , SoftDeletes , HasEagerLimit;

    public $translatedAttributes = ["title", "content", "smallDesc"];
    protected $fillable = [
        "id", "category_id", "deleted_at", "image", "created_at", "updated_at" , 'locale' , 'user_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
