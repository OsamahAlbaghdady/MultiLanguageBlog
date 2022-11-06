<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Category extends Model implements TranslatableContract
{
    use HasFactory, Translatable ,HasEagerLimit;

    protected $table = 'categories';

    public $translatedAttributes = ['title', 'content'];
    protected $fillable = [
        "id", "deleted_at", "image", "parent", "created_at", "updated_at"
    ];

    public function parents()
    {
        return $this->belongsTo(Category::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(Category::class , 'parent');
    }

    public function post()
    {
        return $this->hasMany(Post::class);
    }

}
