<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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
});

//管理者可用
Route::group(['middleware' => 'admin'],function(){
    Route::get('user/index', [UserController::class,'index'])->name('user.index');
    Route::get('user/{user}/change_user', [UserController::class,'change_user'])->name('user.change_user');
    Route::get('user/{user}/{power}/add_user_power', [UserController::class,'add_user_power'])->name('user.add_user_power');
    Route::get('user/{user}/{power}/remove_user_power', [UserController::class,'remove_user_power'])->name('user.remove_user_power');
    Route::get('user/create', [UserController::class,'create'])->name('user.create');
    Route::post('user/store', [UserController::class,'store'])->name('user.store');
    Route::get('user/{user}/edit', [UserController::class,'edit'])->name('user.edit');
    Route::patch('user/{user}/update', [UserController::class,'update'])->name('user.update');
    Route::get('user/{user}/destroy', [UserController::class,'destroy'])->name('user.destroy');
    
});

//評審可用
Route::group(['middleware' => 'review'],function(){
});