<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request; 
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AboutUsController;

Route::get('/language/{locale}', [LanguageController::class, 'language'])->name('language');

Route::resource('files', FileController::class)
    ->middleware(['auth']);

Route::resource('posts', PostController::class)
    ->middleware(['auth']);

Route::resource('places', PlaceController::class)
    ->middleware(['auth']);

Route::post('posts/{post}/likes', [PostController::class, 'like'])->name('posts.like');
Route::delete('posts/{post}/likes', [PostController::class, 'unlike'])->name('posts.unlike');

Route::post('places/{place}/favorites', [PlaceController::class, 'favorite'])->name('places.favorite');
Route::delete('places/{place}/favorites', [PlaceController::class, 'unfavorite'])->name('places.unfavorite');
    
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

Route::get('/dashboard', function (Request $request) {  // Inyecta Request en la función
    $request->session()->flash('info', 'TEST flash messages');
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('mail/test', [MailController::class, 'test']);

require __DIR__.'/auth.php';

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us');