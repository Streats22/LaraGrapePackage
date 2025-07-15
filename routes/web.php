<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPageController;

// Homepage
Route::get('/', [PageController::class, 'home'])->name('home');

// Dynamic pages
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show')
    ->where('slug', '[a-z0-9-_]+');

// GrapesJS save route (for authenticated users only)
Route::post('/{slug}/save-grapesjs', [PageController::class, 'saveGrapesJs'])
    ->name('page.save-grapesjs')
    ->where('slug', '[a-z0-9-_]+')
    ->middleware('auth');

// Admin save route (for authenticated users only)
Route::post('/admin/pages/{page}/save-grapesjs', [AdminPageController::class, 'saveGrapesJs'])
    ->name('admin.page.save-grapesjs')
    ->middleware(['auth']);

Route::get('/admin/block-preview/{blockId}', [\App\Http\Controllers\AdminPageController::class, 'blockPreview'])->name('admin.block-preview');
