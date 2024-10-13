<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\FillController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ReviewController;

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

Route::get('post/index', [PostController::class,'index'])->name('post.index');
Route::get('post/show/{post}', [PostController::class,'show'])->name('post.show');

Route::get('result/index', [ResultController::class,'index'])->name('result.index');
Route::get('result/view/{report}', [ResultController::class,'view'])->name('result.view');
Route::get('result/nonesent/{report}', [ResultController::class,'nonesent'])->name('result.nonesent');
Route::get('result/show/{report}/{code}', [ResultController::class,'show'])->name('result.show');

//使用者可用
Route::group(['middleware' => 'auth'],function(){
    Route::get('impersonate_leave', [HomeController::class,'impersonate_leave'])->name('impersonate_leave');    
    Route::get('fill/index', [FillController::class,'index'])->name('fill.index');
    Route::get('fill/create/{report}', [FillController::class,'create'])->name('fill.create');
    Route::post('fill/store/{upload}', [FillController::class,'store'])->name('fill.store');
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

    Route::get('report/index', [reportController::class,'index'])->name('report.index');
    Route::post('report/store', [reportController::class,'store'])->name('report.store');    
    Route::get('report/edit/{report}', [reportController::class,'edit'])->name('report.edit');
    Route::post('report/update/{report}', [reportController::class,'update'])->name('report.update');
    Route::get('report/destroy/{report}', [reportController::class,'destroy'])->name('report.destroy');
    Route::post('report/upload_copy/{report}', [reportController::class,'upload_copy'])->name('report.upload_copy');
    Route::get('report/upload_create/{report}', [reportController::class,'upload_create'])->name('report.upload_create');
    Route::post('report/upload_store', [reportController::class,'upload_store'])->name('report.upload_store');
    Route::get('report/upload_destroy/{upload}', [reportController::class,'upload_destroy'])->name('report.upload_destroy');
    Route::get('report/upload_edit/{upload}', [reportController::class,'upload_edit'])->name('report.upload_edit');
    Route::post('report/upload_update/{upload}', [reportController::class,'upload_update'])->name('report.upload_update');    
    Route::post('report/comment_copy/{report}', [reportController::class,'comment_copy'])->name('report.comment_copy');
    Route::get('report/comment_create/{report}', [reportController::class,'comment_create'])->name('report.comment_create');
    Route::post('report/comment_store', [reportController::class,'comment_store'])->name('report.comment_store');
    Route::get('report/comment_destroy/{comment}', [reportController::class,'comment_destroy'])->name('report.comment_destroy');
    Route::get('report/comment_edit/{comment}', [reportController::class,'comment_edit'])->name('report.comment_edit');
    Route::post('report/comment_update/{comment}', [reportController::class,'comment_update'])->name('report.comment_update');    

    
    Route::get('post/create', [PostController::class,'create'])->name('post.create');    
    Route::post('post/store', [PostController::class,'store'])->name('post.store');    
    Route::get('post/edit/{post}', [PostController::class,'edit'])->name('post.edit');
    Route::post('post/update/{post}', [PostController::class,'update'])->name('post.update');
    Route::get('post/destroy/{post}', [PostController::class,'destroy'])->name('post.destroy');
    Route::get('post/{post}/delete_file/{filename}', [PostController::class,'delete_file'])->name('post.delete_file');

    Route::get('link/index', [LinkController::class,'index'])->name('link.index');
    Route::post('link/store', [LinkController::class,'store'])->name('link.store');            
    Route::get('link/edit/{link}', [LinkController::class,'edit'])->name('link.edit');
    Route::post('link/update/{link}', [LinkController::class,'update'])->name('link.update');
    Route::get('link/destroy/{link}', [LinkController::class,'destroy'])->name('link.destroy');
    
});

//評審可用
Route::group(['middleware' => 'review'],function(){
});