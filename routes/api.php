<?php

use App\Http\Controllers\Api\CategoryAdminController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return 1;
});


Route::get('/settings', [SettingController::class, 'index'], 200);
Route::get('/nav_items', [CategoryController::class, 'NavigationItemsShow'], 200);
Route::get('/categories_posts', [CategoryController::class, 'indexPageCategoriesWithPosts'], 200);
Route::get('/post', [PostController::class, 'showPostById'], 200);

Route::post('/login', [LoginController::class, 'login'])->middleware('checkJson');
Route::post('/logout', [LoginController::class, 'logout']);

Route::apiResource('categoryadmin' , CategoryAdminController::class)->except('index' , 'show')->middleware(['auth:sanctum' , 'checkJson']);

