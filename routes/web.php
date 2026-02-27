<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\AccountPage;
use App\Livewire\MatchesList;
use App\Livewire\RankingPage;
use App\Livewire\TagsPage;
use Illuminate\Support\Facades\Route;


Route::group(['namespace' => ''], function () {
    require __DIR__ . '/auth.php';
});

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('/matches', MatchesList::class);


    Route::get('/ranking', RankingPage::class)->name('ranking');

    Route::get('/account', AccountPage::class)->name('account');


     Route::get('/logout', LogoutController::class)
        ->name('logout');
});
