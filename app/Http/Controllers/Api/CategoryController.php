<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function NavigationItemsShow()
    {
        $categories = Category::with('children')->where('parent', 0)->orWhere('parent', null)->get();
        return new CategoryCollection($categories);
    }


    public function indexPageCategoriesWithPosts()
    {
        $categories_with_posts = Category::with(['post' => function ($q) {
            $q->latest()->limit(2);
        }])->get();

        return $categories_with_posts = new CategoryCollection($categories_with_posts);
    }


}
