<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    echo "Home";
});

Route::get('/about', function () {
    return view("about");
});
Route::get('/contact', function () {

    return view("contact");
});

Route::get('/contact', [ContactController::class, 'index']);

// Category Controller 
Route::get('/all.category', [CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/add.category', [CategoryController::class, 'store'])->name('store.category');
Route::get('/category/edit/{id}', [CategoryController::class, 'Edit']);
Route::post('/category/update/{id}', [CategoryController::class, 'Update']);
Route::get('/softDelete/category/{id}', [CategoryController::class, 'SoftDeletes']);
Route::get('/category/restore/{id}', [CategoryController::class, 'Restore']);
Route::get('/category/pdelete/{id}', [CategoryController::class, 'Pdelete']);

// CATEGORY CONTROLLER END 

// BRAND ROUTE START
Route::get('/brand/all', [BrandController::class, 'AllBrand'])->name('all.brand');
Route::post('/add/brand',[BrandController::class, 'StoreBrand'])->name('add.brand');
// BRAND ROUTE END 



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {

        // $users = User::all();
        $users = DB::table('users')->get();
        return view('dashboard', compact('users'));
    })->name('dashboard');
});
