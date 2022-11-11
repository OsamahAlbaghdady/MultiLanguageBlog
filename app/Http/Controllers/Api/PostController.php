<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{


    public function showPostById(Request $request)
    {
        $post = Post::where('id' , $request->post_id)->first();
        $post = PostResource::make($post);
        return $post;
    }


}
