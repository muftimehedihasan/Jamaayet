<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DreamController;
// use Illuminate\Support\Carbon;
use App\Http\Controllers\ProfileController;
use Carbon\Carbon;


Route::get('/', function () {

    $dreams = DB::table('dreams')

    ->join('users', 'dreams.user_id', '=', 'users.id')
    ->select(
        'dreams.id as dream_id',
        'dreams.content',
        'dreams.created_at',
        'dreams.user_id',
        'users.name',
        'users.email'

    )->get();


    $dreams->map(function ($dreams){
        $dreams->created_at = Carbon::make($dreams->created_at);
    });

    return view('welcome', compact('dreams'));
});

// Route::get('/admin/dreams', [DreamController::class, 'index'])->name('dreams.index');

// Route::get('/admin/dreams/{dream}', [DreamController::class, 'show'])->name('dreams.show');

// Route::get('/admin/dreams/create', [DreamController::class, 'create'])->name('dreams.create');

// Route::post('/admin/dreams/store', [DreamController::class, 'store'])->name('dreams.store');

// Route::get('/admin/dreams/{dream}/edit', [DreamController::class, 'edit'])->name('dreams.edit');

// Route::put('/admin/dreams/{dream}', [DreamController::class, 'update'])->name('dreams.update');

// Route::delete('/admin/dreams/{dream}/destroy', [DreamController::class, 'delete'])->name('dreams.destroy');



Route::resource('dreams', DreamController::class)->middleware(['auth']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
