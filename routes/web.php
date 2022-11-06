<?php

use App\Http\Controllers\CategoryController as ControllersCategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




###################### Website Start ###########################


Route::get('/', [WebsiteController::class, 'index'])->name('index');
Route::get('/categories/{category}',[WebsiteController::class , 'showCategories'])->name('category');
Route::get('/posts/{post}', [WebsiteController::class , 'showPost'])->name('post');


###################### Website End ###########################








###################### Dashboard Start ################################

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth', 'checkLogin'])->group(
    function () {


        Route::get(
            '/',
            function () {
                return view('dashboard.index');
            }
        )->name(
            'index'
        );

        Route::prefix('settings')->name('setting')->group(
            function () {

                Route::get('/', [SettingController::class, 'index']);
                Route::post('/update/{setting}', [SettingController::class, 'update'])->name('.update');
            }
        );

        Route::get('users/all', [UserController::class, 'getUsersAll'])->name('users.all');
        Route::post('users/delete', [UserController::class, 'delete'])->name('users.delete');

        Route::get('categories/all', [CategoryController::class, 'getCategoriesAll'])->name('category.all');
        Route::post('categories/delete', [CategoryController::class, 'delete'])->name('category.delete');


        Route::get('posts/all', [PostController::class, 'getPostsAll'])->name('posts.all');
        Route::post('posts/delete', [PostController::class, 'delete'])->name('posts.delete');

        Route::resources(
            [
                'users' => UserController::class,
                'categories' => CategoryController::class,
                'posts' => PostController::class
            ]
        );
    }
);


Auth::routes();


 ###################### Dashboard End ################################
