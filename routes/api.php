<?php

use App\Http\Controllers\Api\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/' , function(){
 return 1;
});


Route::get('/settings' , [SettingController::class , 'index'] , 200);
