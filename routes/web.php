<?php
use Carbon\Carbon;
use App\Models\Sessions;
use App\Models\User;
use App\Models\Transaction;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

function dailyBonusCheck() {
    // See if elegible for daily bonus
    $user = auth()->user();

    $timestamp = $user->last_log;
    $date = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp);

    if (!$date->isToday()) {
        //Claim daily bonus
        $tr = Transaction::create([
            'user_id' => $user->id,
            'amount' => 1000,
            'type' => 0
        ]);
        $user->coins = $user->coins + 1000;
        $user->last_log = Carbon::now()->timezone('UTC');
        $user->save();
    }
}



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
    dailyBonusCheck();
    return view('main', [
        'user' => auth()->user()
    ]);
})->middleware('auth');

Route::get('/games', function () {
    dailyBonusCheck();
    return view('games');
})->middleware('auth');

Route::get('/profile', function () {
    dailyBonusCheck();
    return view('profile', [
        'transactions' => Transaction::where('user_id', '=', auth()->user()->id)->get()->reverse()
    ]);
})->middleware('auth');

Route::get('/api/users', [ApiController::class, 'send_users']);

Route::get('/api/timezone', [ApiController::class, 'timezone']);

Route::get('login', [SessionController::class, 'create'])->middleware('guest')->name('login');

Route::post('logout', [SessionController::class, 'destroy'])->middleware('auth');