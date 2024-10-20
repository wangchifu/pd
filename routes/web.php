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
use App\Http\Controllers\ReviewerController;

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
    Route::get('password_edit', [HomeController::class,'password_edit'])->name('password_edit');
    Route::patch('password_update', [HomeController::class,'password_update'])->name('password_update');
    Route::get('fill/index', [FillController::class,'index'])->name('fill.index');
    Route::get('fill/award/{report}', [FillController::class,'award'])->name('fill.award');
    Route::get('fill/create/{report}', [FillController::class,'create'])->name('fill.create');
    Route::post('fill/store/{upload}', [FillController::class,'store'])->name('fill.store');    
});

//管理者可用
Route::group(['middleware' => 'admin'],function(){
    Route::get('password_reset/{user}', [UserController::class,'password_reset'])->name('user.password_reset');
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

    Route::get('report/index', [ReportController::class,'index'])->name('report.index');
    Route::post('report/store', [ReportController::class,'store'])->name('report.store');    
    Route::get('report/edit/{report}', [ReportController::class,'edit'])->name('report.edit');
    Route::post('report/update/{report}', [ReportController::class,'update'])->name('report.update');
    Route::get('report/destroy/{report}', [ReportController::class,'destroy'])->name('report.destroy');
    Route::post('report/upload_copy/{report}', [ReportController::class,'upload_copy'])->name('report.upload_copy');
    Route::get('report/upload_create/{report}', [ReportController::class,'upload_create'])->name('report.upload_create');
    Route::post('report/upload_store', [ReportController::class,'upload_store'])->name('report.upload_store');
    Route::get('report/upload_destroy/{upload}', [ReportController::class,'upload_destroy'])->name('report.upload_destroy');
    Route::get('report/upload_edit/{upload}', [ReportController::class,'upload_edit'])->name('report.upload_edit');
    Route::post('report/upload_update/{upload}', [ReportController::class,'upload_update'])->name('report.upload_update');    
    Route::post('report/comment_copy/{report}', [ReportController::class,'comment_copy'])->name('report.comment_copy');
    Route::get('report/comment_create/{report}', [ReportController::class,'comment_create'])->name('report.comment_create');
    Route::post('report/comment_store', [ReportController::class,'comment_store'])->name('report.comment_store');
    Route::get('report/comment_destroy/{comment}', [ReportController::class,'comment_destroy'])->name('report.comment_destroy');
    Route::get('report/comment_edit/{comment}', [ReportController::class,'comment_edit'])->name('report.comment_edit');
    Route::post('report/comment_update/{comment}', [ReportController::class,'comment_update'])->name('report.comment_update');        
    
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

    Route::get('review/index', [ReviewController::class,'index'])->name('review.index');
    Route::get('review/school_assign/{report}', [ReviewController::class,'school_assign'])->name('review.school_assign');
    Route::get('review/school_assign_copy/{old_id}/{new_id}', [ReviewController::class,'school_assign_copy'])->name('review.school_assign_copy');
    Route::post('review/do_school_assign', [ReviewController::class,'do_school_assign'])->name('review.do_school_assign');
    Route::get('review/check_group/{report_id}/{name}', [ReviewController::class,'check_group'])->name('review.check_group');
    Route::get('review/score', [ReviewController::class,'score'])->name('review.score');
    Route::get('review/import/{report}', [ReviewController::class,'import'])->name('review.import');
    Route::post('review/do_import', [ReviewController::class,'do_import'])->name('review.do_import');
    Route::post('review/award', [ReviewController::class,'award'])->name('review.award');
    
});

//評審可用
Route::group(['middleware' => 'review'],function(){
    Route::get('reviewer/index', [ReviewerController::class,'index'])->name('reviewer.index');
    Route::get('reviewer/school/{report}/{school_code}', [ReviewerController::class,'school'])->name('reviewer.school');
    Route::post('reviewer/school_store', [ReviewerController::class,'school_store'])->name('reviewer.school_store');
});