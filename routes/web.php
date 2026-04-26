<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\AccountPage;
use App\Livewire\HomePage;
use App\Livewire\HowToPlayPage;
use App\Livewire\MatchesList;
use App\Livewire\RankingPage;
use App\Livewire\StatsPage;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => ''], function () {
    require __DIR__.'/auth.php';
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['pt_BR', 'en'])) {
        session(['lang' => $locale]);
    }

    return back();
})->name('lang.switch');

Route::middleware('auth')->group(function () {

    Route::get('/', HomePage::class)->name('home');

    Route::get('/matches', MatchesList::class)->name('matches');

    Route::get('/ranking', RankingPage::class)->name('ranking');

    Route::get('/account', AccountPage::class)->name('account');

    Route::get('/stats', StatsPage::class)->name('stats');

    Route::get('/how-to-play', HowToPlayPage::class)->name('how-to-play');

    Route::get('/logout', LogoutController::class)
        ->name('logout');
});
