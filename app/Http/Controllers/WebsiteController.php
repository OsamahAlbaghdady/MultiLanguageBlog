<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {

        $categories_with_posts = Category::with(['post' => function ($q) {
            $q->latest()->limit(2);
        }])->get();

        return view('website.index')->with([
            'categories_with_posts' => $categories_with_posts
        ]);
    }



    public function showCategories(Category $category)
    {
        $category->load('children');
        $posts = Post::where('category_id', $category->id)->paginate(2);
        return view('website.category', compact('category', 'posts'));
    }


    public function showPost(Post $post)
    {
       return view('website.post' , compact('post'));
    }
}
