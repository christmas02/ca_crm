<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CollectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Application mobile agent terrain
|--------------------------------------------------------------------------
|
| POST   /api/login         Connexion agent terrain (identifiant + password)
| POST   /api/logout        Déconnexion (révoque le token Sanctum)
| POST   /api/collect       Soumettre une collecte terrain (multipart/form-data)
| GET    /api/my-collects   Liste des collectes de l'agent connecté
|
*/

// ── Public ────────────────────────────────────────────────────────────────────
Route::post('/login', [AuthController::class, 'login']);

// ── Authentifié (Sanctum) ─────────────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/collect',    [CollectController::class, 'store']);
    Route::get('/my-collects', [CollectController::class, 'myCollects']);
});
