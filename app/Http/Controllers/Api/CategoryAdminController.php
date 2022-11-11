<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryAdminController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->authorize('viewAny', Category::class);

        $data = $request->except([
            'image',
            '_token'
        ]);


        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(base_path('assets/admin/img/category'), $filename);
            $data['image'] = 'assets/admin/img/category/' . $filename;
        }



        $categories = CategoryResource::make(Category::create($data));

        return response()->json([
            'data' =>  $categories,
            'msg' => 'category created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $categoryadmin)
    {
        $category = $categoryadmin;

        $this->authorize('create', Category::class);

        $data = $request->except([
            'image',
            '_token'
        ]);


        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(base_path('assets/admin/img/category'), $filename);
            $data['image'] = 'assets/admin/img/category/' . $filename;
        }

        $category->update($data);

        return response()->json([
            'data' => CategoryResource::make($category),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $categoryadmin)
    {
        $this->authorize('create', Category::class);

        if (is_numeric($categoryadmin->id)) {
            Category::where('parent', $categoryadmin->id)->delete();
            Category::where('id', $categoryadmin->id)->delete();
        }


        return response()->json([
            'msg' => 'delete successful'
        ]);
    }
}
