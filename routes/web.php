<?php

use LaraGrape\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use LaraGrape\Http\Controllers\AdminPageController;
use LaraGrape\Models\Page;

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

Route::get('/admin/block-preview/{blockId}', [AdminPageController::class, 'blockPreview'])->name('admin.block-preview');

// Debug route for testing GrapesJS data flow
Route::get('/debug/grapesjs-data/{page}', function ($page) {
    $page = Page::find($page);
    if (!$page) {
        return response()->json(['error' => 'Page not found']);
    }
    
    return response()->json([
        'page_id' => $page->id,
        'grapesjs_data' => $page->grapesjs_data,
        'blade_content' => $page->blade_content,
        'has_original_grapesjs' => isset($page->grapesjs_data['original_grapesjs']),
        'original_grapesjs_keys' => isset($page->grapesjs_data['original_grapesjs']) ? array_keys($page->grapesjs_data['original_grapesjs']) : [],
        'grapesjs_data_keys' => array_keys($page->grapesjs_data ?? [])
    ]);
})->name('debug.grapesjs-data');
