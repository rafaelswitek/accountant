<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomFieldsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\PipelineController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/image', [ProfileController::class, 'showImage'])->name('profile.image');

    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::get('/company/create', [CompanyController::class, 'create'])->name('company.create');
    Route::post('/company', [CompanyController::class, 'store'])->name('company.store');
    Route::get('/company/{id}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::put('/company/{id}', [CompanyController::class, 'update'])->name('company.update');
    Route::get('/company/list', [CompanyController::class, 'list'])->name('company.list');
    Route::get('/company/search', [CompanyController::class, 'search'])->name('company.search');
    Route::get('/company/image', [CompanyController::class, 'showImage'])->name('company.image');

    Route::put('/pipeline/update-deal', [PipelineController::class, 'updateDeal']);
    Route::get('/pipeline', [PipelineController::class, 'index'])->name('pipeline.index');
    Route::get('/pipeline/create', [PipelineController::class, 'create'])->name('pipeline.create');
    Route::post('/pipeline', [PipelineController::class, 'store'])->name('pipeline.store');
    Route::get('/pipeline/{id}/edit', [PipelineController::class, 'edit'])->name('pipeline.edit');
    Route::put('/pipeline/{id}', [PipelineController::class, 'update'])->name('pipeline.update');

    Route::post('/deal', [DealController::class, 'create'])->name('deal.create');
    Route::get('/deal/{id}', [DealController::class, 'show'])->name('pipeline.deal');
    Route::put('/deal/{id}', [DealController::class, 'update'])->name('deal.update');
    Route::delete('/deal/{id}', [DealController::class, 'destroy'])->name('deal.destroy');
    Route::post('/deal/{id}/activity', [ActivityController::class, 'store'])->name('deal.activity.store');
    Route::put('/deal/activity/{id}', [ActivityController::class, 'update'])->name('deal.activity.update');
    Route::delete('/deal/activity/{id}', [ActivityController::class, 'destroy'])->name('deal.activity.destroy');

    Route::get('/custom-fields', [CustomFieldsController::class, 'index'])->name('fields.index');
    Route::get('/custom-fields/create', [CustomFieldsController::class, 'create'])->name('fields.create');
    Route::post('/custom-fields', [CustomFieldsController::class, 'store'])->name('fields.store');
    Route::get('/custom-fields/{id}/edit', [CustomFieldsController::class, 'edit'])->name('fields.edit');
    Route::put('/custom-fields/{id}', [CustomFieldsController::class, 'update'])->name('fields.update');
    Route::get('/custom-fields/list', [CustomFieldsController::class, 'list'])->name('fields.list');
});

require __DIR__ . '/auth.php';
