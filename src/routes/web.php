<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use
App\Http\Controllers\ListingController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// Route::get('/users', [UserController::class, 'index'])->name('users.index'); 
//ログイン画面 
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
//登録画面 
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register'); 
Route::post('/register', [RegisterController::class, 'register']);
 // 商品一覧画面
Route::get('/',[ItemController::class,'index']);
 // 商品検索機能
Route::get('/search', [ItemController::class, 'search'])->name('search');
 // // 商品出品画面
Route::get('/sell',[ItemController::class,'create'])->name('sell');
Route::post('/sell',[ItemController::class,'store'])->name('sell');
 //プロフィール画面
Route::get('/mypage',[ProfileController::class,'show'])->name('mypage');
// プロフィール編集画面
// Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('mypage');
// Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('mypage.profile');
Route::middleware(['auth'])->group(function () {
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('mypage.profile');
    Route::post('/mypage/profile', [ProfileController::class, 'update']);
});
//いいね機能
Route::post('/item/{item_id}',  [NiceController::class, 'store'])
    ->middleware('auth')
    ->name('nice.store');