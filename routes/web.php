<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InsurancePartnerController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Opportunities
    Route::get('opportunities/new', [OpportunityController::class, 'listNewOpportunities'])->name('opportunities.new');
    Route::get('opportunities/renewals', [OpportunityController::class, 'listRenewals'])->name('opportunities.renewals');
    Route::resource('opportunities', OpportunityController::class);
    Route::post('opportunities/{opportunity}/assign', [OpportunityController::class, 'assign'])->name('opportunities.ass ign');
    Route::post('opportunities/{opportunity}/status', [OpportunityController::class, 'changeStatus'])->name('opportunities.change-status');
    Route::post('opportunities/bulk/assign', [OpportunityController::class, 'bulkAssign'])->name('opportunities.bulkAssign');


    // Comments
    Route::post('opportunities/{opportunity}/comments', [CommentController::class, 'store'])->name('comments.store');

    // Clients (opportunités gagnées)
    Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('clients/{client}', [ClientController::class, 'show'])->name('clients.show');

    // Contracts
    Route::resource('contracts', ContractController::class);
    Route::get('opportunities/{opportunity}/create-contract', [ContractController::class, 'createFromOpportunity'])->name('opportunities.create-contract');

    // Admin only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('teams', TeamController::class)->except(['show']);
        Route::resource('insurance-partners', InsurancePartnerController::class);
    });
});

require __DIR__.'/auth.php';
