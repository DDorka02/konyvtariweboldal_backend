<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FelhasznaloKonyvController;
use App\Http\Controllers\JelentesController;
use App\Http\Controllers\KicserelesController;
use App\Http\Controllers\KonyvController;
use App\Http\Controllers\KonyvKeresController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
});

Route::middleware('auth:sanctum')->post('/update-user/{user}', [UserController::class, 'update'])->name('update-user');
Route::middleware('auth:sanctum')->get('/get-user/{id}', [UserController::class, 'getUser']);
Route::middleware('auth:sanctum')->post('/update-password', [UserController::class, 'updatePassword']);

// MINDEN MÁS ROUTE VÉDELT
Route::middleware('auth:sanctum')->group(function () {
    
    // Felhasználó profil
    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    Route::middleware('auth:sanctum')->group(function () {
    Route::get('/konyvek', [KonyvController::class, 'index']);
    Route::post('/konyvAdd', [KonyvController::class, 'store']);
    Route::get('/konyvMegmutat/{id}', [KonyvController::class, 'show']);
    Route::put('/konyvModosit/{id}', [KonyvController::class, 'update']);
    Route::delete('/konyvTorol/{id}', [KonyvController::class, 'destroy']);
    });


    // FELHASZNÁLÓK
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/userAdd', [UserController::class, 'store']);
    Route::get('/userMegmutat/{id}', [UserController::class, 'show']);
    Route::put('/userModosit/{id}', [UserController::class, 'update']);
    Route::delete('/userTorol/{id}', [UserController::class, 'destroy']);



    Route::middleware('auth:sanctum')->group(function () {
    // FELHASZNÁLÓ KÖNYVEI - CSAK BEJELENTKEZETT FELHASZNÁLÓK
    Route::get('/felhasznaloKonyvek', [FelhasznaloKonyvController::class, 'index']);
    Route::post('/felhasznaloKonyvAdd', [FelhasznaloKonyvController::class, 'store']);
    Route::get('/felhasznaloKonyvMegmutat/{id}', [FelhasznaloKonyvController::class, 'show']);
    Route::put('/felhasznaloKonyvModosit/{id}', [FelhasznaloKonyvController::class, 'update']);
    Route::delete('/felhasznaloKonyvTorol/{id}', [FelhasznaloKonyvController::class, 'destroy']);
});

    // KÖNYVKERESÉSEK
    Route::get('/konyvKeresesek', [KonyvKeresController::class, 'index']);
    Route::post('/konyvKeresesAdd', [KonyvKeresController::class, 'store']);
    Route::get('/konyvKeresesMegmutat/{id}', [KonyvKeresController::class, 'show']);
    Route::put('/konyvKeresesModosit/{id}', [KonyvKeresController::class, 'update']);
    Route::delete('/konyvKeresesTorol/{id}', [KonyvKeresController::class, 'destroy']);

    // CSERÉK
    Route::get('/cserék', [KicserelesController::class, 'index']);
    Route::post('/csereAdd', [KicserelesController::class, 'store']);
    Route::get('/csereMegmutat/{id}', [KicserelesController::class, 'show']);
    Route::put('/csereModosit/{id}', [KicserelesController::class, 'update']);
    Route::delete('/csereTorol/{id}', [KicserelesController::class, 'destroy']);

    // JELENTÉSEK
    Route::get('/jelentesek', [JelentesController::class, 'index']);
    Route::post('/jelentesAdd', [JelentesController::class, 'store']);
    Route::get('/jelentesMegmutat/{id}', [JelentesController::class, 'show']);
    Route::put('/jelentesModosit/{id}', [JelentesController::class, 'update']);
    Route::delete('/jelentesTorol/{id}', [JelentesController::class, 'destroy']);

});