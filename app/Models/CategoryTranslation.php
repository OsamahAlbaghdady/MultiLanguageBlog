<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use HasFactory;

    protected $table = 'categories_translation';


    public $timestamps = false;
    protected $fillable = ["id", "category_id", "locale", "title", "content"];
}
