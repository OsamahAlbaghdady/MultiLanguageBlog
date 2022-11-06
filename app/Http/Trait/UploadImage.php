<?php

namespace App\Http\Trait;

trait UploadImage
{
    public function upload($request , $folderName , $data)
    {
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(base_path('assets/admin/img/'.$folderName), $filename);
            $data['image'] = 'assets/admin/img/'.$folderName.'/'. $filename;

        }
        return $data;
    }
}
