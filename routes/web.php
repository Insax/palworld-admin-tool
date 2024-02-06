<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

try {
    if (Schema::hasTable('migrations')) {
        Route::get('/', function () {
            if (\App\Models\User::count() == 0)
                return redirect()->route('register');
            else
                return redirect()->route('login');
        });

        Route::get('dashboard', \App\Livewire\Dashboard::class)
            ->middleware(['auth', 'verified'])
            ->name('dashboard');;

        Route::get('dashboard/{id}', \App\Livewire\ServerDashboard::class)
            ->middleware(['auth', 'verified'])
            ->name('server-dashboard');;

        Route::view('profile', 'profile')
            ->middleware(['auth'])
            ->name('profile');

        Route::get('users', \App\Livewire\UserOverview::class)
            ->middleware(['auth', 'verified'])
            ->name('user-overview');

        Route::get('servers', \App\Livewire\ServerOverview::class)
            ->middleware(['auth', 'verified'])
            ->name('server-overview');

        Route::get('rcon', \App\Livewire\RconOverview::class)
            ->middleware(['auth', 'verified'])
            ->name('rcon-overview');

        Route::get('rcon/add', \App\Livewire\AddRcon::class)
            ->middleware(['auth', 'verified'])
            ->name('add-rcon');

        Route::get('server/add', \App\Livewire\AddServer::class)
            ->middleware(['auth', 'verified'])
            ->name('add-server');

        Route::get('server/edit/{id}', \App\Livewire\EditServer::class)
            ->middleware(['auth', 'verified'])
            ->name('edit-server');

        Route::get('server/{id}/whitelist', \App\Livewire\EditWhitelist::class)
            ->middleware(['auth', 'verified'])
            ->name('edit-whitelist');

        require __DIR__ . '/auth.php';
    } else {
        Route::get('{any}', \App\Livewire\Installer::class)->name('installer')->where('any', '.*');
    }
} catch(\Illuminate\Database\QueryException $ex) {
    Route::get('{any}', \App\Livewire\Installer::class)->name('installer')->where('any', '.*');
}
