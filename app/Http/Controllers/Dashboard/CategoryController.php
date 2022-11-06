<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    // private $user;

    // public function __construct()
    // {
    //      $this->user = User::where('id'  ,  auth()->user()->id)->get();
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('create', Category::class);
        return view('dashboard.categoriees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function getCategoriesAll(Category $category)
    {
        return  Datatables::collection(Category::with('parents')->get())->addColumn('action', function ($row) {
            $btn = '';

            if (auth()->user()->can('update', $row)) {
                $btn .= '<a href="' . Route('dashboard.categories.edit', $row->id) . '"  class="edit btn btn-success btn-sm" ><i class="fa fa-edit"></i></a>';
            }
            if (auth()->user()->can('delete', $row)) {
                $btn .= '<a id="deleteBtn" data-id="' . $row->id . '" class="edit btn btn-danger btn-sm"  data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a>';
            }
            return $btn;
        })
            ->addColumn('parent', function ($row) {
                return $row->parent > 0 ? $row->parents->translate(app()->getLocale())->title : __('words.main_category');
            })
            ->rawColumns(['action'])->make(true);
    }




    public function create()
    {
        $this->authorize('create', Category::class);
        $categories = Category::whereNull('parent')->orWhere("parent", 0)->get();
        return view('dashboard.categoriees.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
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



        $categories = $category->create($data);

        return redirect()->route('dashboard.categories.index', compact('categories'));
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
    public function edit($id)
    {
        $this->authorize('create', Category::class);
        $category = Category::where('id', $id)->first();
        $categories = Category::whereNull('parent')->orWhere("parent", 0)->get();
        return view('dashboard.categoriees.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
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

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }


    public function delete(Request $request, Category $category)
    {
        $this->authorize('create', Category::class);

        if (is_numeric($request->id)) {
            Category::where('parent', $request->id)->delete();
            Category::where('id', $request->id)->delete();
        }

        return redirect()->route('dashboard.categories.index');
    }
}
