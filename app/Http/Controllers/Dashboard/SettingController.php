<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
        $this->authorize('view' , $setting);
        return view('dashboard.settings');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $this->authorize('update' , $setting);

        $validate = [
            'logo' => 'nullable|image:jpg,png,jpeg,gif,svg|max:2048',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ];


        foreach (config('app.languages') as $key => $lang) {
            $validate[$key . '*.title'] = 'nullable|string';
            $validate[$key . '*.content'] = 'nullable|string';
            $validate[$key . '*.address'] = 'nullable|string';
        }

        $request->validate($validate);


        $data = $request->except([
            'logo',
            'favicon',
            '_token'
        ]);


        if ($request->file('logo')) {
            $file = $request->file('logo');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(base_path('assets/admin/img/profile'), $filename);
            $data['logo'] = 'assets/admin/img/profile/'.$filename;
        }


        if ($request->file('favicon')) {
            $file = $request->file('favicon');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(base_path('assets/admin/img/profile'), $filename);
            $data['favicon'] = 'assets/admin/img/profile/'.$filename;
        }


        $setting->update($data);

        return redirect()->route('dashboard.setting');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
