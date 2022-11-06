<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.users.index');
    }






    public function getUsersAll(User $user)
    {
        auth()->user()->can('viewAny' , $user) ? $data = User::get() : $data = User::where('id' , auth()->user()->id)->get();
        return Datatables::collection($data)->addColumn('action', function ($row) {
            $btn = '';
            if (auth()->user()->can('update', $row)) {
            $btn .= '<a href="' . Route('dashboard.users.edit', $row->id) . '"  class="edit btn btn-success btn-sm" ><i class="fa fa-edit"></i></a>
            <a id="deleteBtn" data-id="' . $row->id . '" class="edit btn btn-danger btn-sm"  data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a>
            ';
            }
            if (auth()->user()->can('delete', $row)) {
                $btn .= '
                    <a id="deleteBtn" data-id="' . $row->id . '" class="edit btn btn-danger btn-sm"  data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a>';
            }
            return $btn;
        })
            ->addColumn('status', function ($row) {
                return $row->status == null ? __('words.not activated') : __('words.' . $row->status);
            })
            ->rawColumns(['action', 'status'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('id' , auth()->user()->id)->first();
        $this->authorize('create' , $user);
        return view('dashboard.users.add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::where('id' , auth()->user()->id)->first();
        $this->authorize('create' , $user);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'status' => 'required|in:null,admin,writer',
            'password' => 'required'
        ]);

        User::create($request->all());

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update' , $user);

        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update' , $user);
        $request->validate([
            'name' => "required",
            'email' => "required",
        ]);
        $user ? $user->update($request->all()) : '';

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }


    public function delete(Request $request, User $user)
    {
        $this->authorize('update' , $user);
        $user = $user->where('id', $request->id)->first();
        $user ? $user->delete() : '';
        return redirect()->route('dashboard.users.index');
    }
}
