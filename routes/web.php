<?php
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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
//     return redirect("/dashboard");
// })->middleware('admin');

Route::get('/', function () {
    return view('main');
})->middleware('auth');


Route::get('login', [SessionController::class, 'create'])->middleware('guest')->name('login');
Route::middleware(['throttle:authenticate'])->post('login', [SessionController::class, 'store'])->middleware('guest');

Route::get('exit', [SessionController::class, 'exit'])->middleware('auth')->name('exit');

Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::middleware(['throttle:authenticate'])->post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::post('logout', [SessionController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('logout', function () {
    return redirect("/");
});

Route::get('dashboard', [AdminController::class, 'create'])->middleware('admin');

Route::post('update', [AdminController::class, 'update'])->middleware('admin')->name('update');

