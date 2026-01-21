<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
// use App\Http\Middleware\EnsureEmployer;
// use App\Http\Middleware\EnsureApplicant;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'applicant'])->group(function () {

    Route::get('/applicant/index', function () {
        return Inertia::render('applicant/Index');
    })->name('applicant.index');

});

Route::middleware(['auth', 'employer'])->group(function () {
    Route::get('/employer/index', function () {
        return Inertia::render('employer/Index');
    })->name('employer.index');

});

require __DIR__.'/settings.php';
