<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Trait\UploadImage;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    use UploadImage;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.posts.index');
    }


    public function getPostsAll(Post $post)
    {

        return Datatables::collection(Post::with('category')->get())->addColumn('action', function ($row) {
            $btn = '';
            if (auth()->user()->can('update', $row)) {
                $btn .= '<a href="' . Route('dashboard.categories.edit', $row->id) . '"  class="edit btn btn-success btn-sm" ><i class="fa fa-edit"></i></a>';
            }
            if (auth()->user()->can('delete', $row)) {
                $btn .= '<a id="deleteBtn" data-id="' . $row->id . '" class="edit btn btn-danger btn-sm"  data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a>';
            }

            return $btn;
        })
            ->addColumn('category_name', function ($row) {
                return $row->category->translate(app()->getLocale())->title;
            })
            ->addColumn('title', function ($row) {
                return $row->title;
            })
            ->rawColumns(['action', 'title', 'category_name'])->make(true);
    }






    public function create()
    {
        $categories = Category::all();
        return count($categories) > 0 ? view('dashboard.posts.add', compact('categories')) : redirect()->route('dashboard.categories.create')->withErrors(['msg' => 'create category first']);
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {

        $data = $request->except([
            'image',
            '_token'
        ]);

        $data = $this->upload($request, 'posts', $data);


        $data['user_id'] = auth()->user()->id;
        $posts = $post->create($data);

        return redirect()->route('dashboard.posts.index', compact('posts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $categories = Category::where('parent', 0)->get();
        return view('dashboard.posts.edit', compact('categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $request->except([
            'image',
            '_token'
        ]);


        $data = $this->upload($request, "posts", $data);
        $data['user_id'] = auth()->user()->id;

        $post->update($data);

        return redirect()->route('dashboard.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }



    public function delete(Request $request, Post $post)
    {
        $post = $post->where('id', $request->id)->first();
        $post ? $post->delete() : '';
        return redirect()->route('dashboard.posts.index');
    }
}
