<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
 */
Route::get('/', [HomeController::class,'index'])->name('index');
Route::get('glogin', [HomeController::class,'glogin'])->name('glogin');
Route::post('gauth', [HomeController::class,'gauth'])->name('gauth');
Route::get('login', [HomeController::class,'login'])->name('login');
Route::post('auth', [HomeController::class,'auth'])->name('auth');
Route::get('logout', [HomeController::class,'logout'])->name('logout');
Route::get('pic', [HomeController::class,'pic'])->name('pic');

Route::get('/', [HomeController::class,'index'])->name('index');

//使用者可用
Route::group(['middleware' => 'auth'],function(){
    Route::get('impersonate_leave', [HomeController::class,'impersonate_leave'])->name('impersonate_leave');    
});

//管理者可用
Route::group(['middleware' => 'admin'],function(){
    Route::get('impersonate/{user}', [HomeController::class,'impersonate'])->name('impersonate');   
    Route::get('user/index', [UserController::class,'index'])->name('user.index');
    Route::get('user/{user}/change_user', [UserController::class,'change_user'])->name('user.change_user');
    Route::get('user/{user}/{power}/add_user_power', [UserController::class,'add_user_power'])->name('user.add_user_power');
    Route::get('user/{user}/{power}/remove_user_power', [UserController::class,'remove_user_power'])->name('user.remove_user_power');
    Route::get('user/create', [UserController::class,'create'])->name('user.create');
    Route::post('user/store', [UserController::class,'store'])->name('user.store');
    Route::get('user/{user}/edit', [UserController::class,'edit'])->name('user.edit');
    Route::patch('user/{user}/update', [UserController::class,'update'])->name('user.update');
    Route::get('user/{user}/destroy', [UserController::class,'destroy'])->name('user.destroy');
    Route::post('user/search', [UserController::class,'search'])->name('user.search');

    Route::get('year/index', [YearController::class,'index'])->name('year.index');
    Route::post('year/store', [YearController::class,'store'])->name('year.store');
    Route::get('year/create_item/{year}', [YearController::class,'create_item'])->name('year.create_item');
    Route::post('year/item_store', [YearController::class,'item_store'])->name('year.item_store');
    Route::get('year/item_destroy/{item}', [YearController::class,'item_destroy'])->name('year.item_destroy');
    Route::get('year/edit_item/{item}', [YearController::class,'edit_item'])->name('year.edit_item');
    Route::post('year/update_item/{item}', [YearController::class,'item_update'])->name('year.update_item');
    Route::post('year/copy_year/{year}', [YearController::class,'copy_year'])->name('year.copy_year');
    Route::get('year/edit_year/{year}', [YearController::class,'edit_year'])->name('year.edit_year');
    Route::post('year/update/{year}', [YearController::class,'update_year'])->name('year.update_year');
    Route::get('year/year_destroy/{year}', [YearController::class,'year_destroy'])->name('year.year_destroy');

    Route::get('post/index', [PostController::class,'index'])->name('post.index');
    Route::get('post/create', [PostController::class,'create'])->name('post.create');    
    Route::post('post/store', [PostController::class,'store'])->name('post.store');
    Route::get('post/show/{post}', [PostController::class,'show'])->name('post.show');
    Route::get('post/edit/{post}', [PostController::class,'edit'])->name('post.edit');
    Route::post('post/update/{post}', [PostController::class,'update'])->name('post.update');
    Route::get('post/destroy/{post}', [PostController::class,'destroy'])->name('post.destroy');
    Route::get('post/{post}/delete_file/{filename}', [PostController::class,'delete_file'])->name('post.delete_file');
    
});

//評審可用
Route::group(['middleware' => 'review'],function(){
});