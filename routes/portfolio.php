<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPortfolioProjectController;
use App\Http\Controllers\PortfolioProjectController;

if (! config('laragrape.portfolio_enabled', false)) {
    return;
}

Route::get('/portfolio/{slug}', [PortfolioProjectController::class, 'show'])
    ->name('portfolio.show')
    ->where('slug', '[a-z0-9-_]+');

Route::post('/portfolio/{portfolioProject}/save-grapesjs', [PortfolioProjectController::class, 'saveGrapesJs'])
    ->name('portfolio.save-grapesjs')
    ->middleware('auth');

Route::post('/admin/portfolio-projects/{portfolioProject}/save-grapesjs', [AdminPortfolioProjectController::class, 'saveGrapesJs'])
    ->name('admin.portfolio-project.save-grapesjs')
    ->middleware(['auth']);
